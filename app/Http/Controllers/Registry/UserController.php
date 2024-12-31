<?php

namespace App\Http\Controllers\Registry;

use Exception;
use ReflectionClass;
use App\Models\Group;
use App\Models\Location;
use App\Enums\SyncStatus;
use Illuminate\Http\Request;

use App\Http\Traits\CatalogLocation;
use App\Jobs\UpdatedBiometricRecord;
use App\Http\Traits\ParentRelationable;
use App\Http\Utilities\BiometricsUtilities;
use App\Http\Services\MatcherService\MatcherFingerService;
use App\Models\contracts\InterfaceParentModelRelationable;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class UserController extends AbstractCoreController
{

    use ParentRelationable;

    use CatalogLocation;

    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig('registry.user');
    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(string $configPath): string
    {

        $configPath = parent::initConfig($configPath);
        // Ejemplo validaciones adicionaes
        $class = new ReflectionClass($this->model);
        $instance = $class->newInstance();
        if (!$instance instanceof InterfaceParentModelRelationable)
            throw new Exception($class->getShortName() . ' not instace of InterfaceParentModelRelationable', 400);



        return $configPath;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();

            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails())
                return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            BiometricsUtilities::isValideLocations($input['locationKeys']);

            $terminal = BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);

            if (empty($terminal))
                return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);

            $company = $terminal->company;

            $groups = Group::whereIn('key', $input['groupKeys'])->get();

            if (empty($groups))
                return $this->sendError('Not Found group', 'No se encontraron Grupos', 404);


            $locations = Location::whereIn('key', $input['locationKeys'])->get();

            if (empty($locations))
                return $this->sendError('Not Found group', 'No se encontraron Sucursales', 404);

            // Valide duplicate email
            if (QueryUtilities::isDuplicateRecord($model, 'email', $input['email']))
                return $this->sendError('Error de validacion', "The email " . $input['email'] . " has already been taken.", 422);

            $model->fill($input);
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->terminalType;

            $parentRelation = config('registry.user.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass = $parentRelation['related'];
                $model->parentModelKey = $parentRelation['otherKey'];
                $model->parentModelIndex = $input['parentModelIndex'];
            }

            $model->save();

            $terminal->users()->save($model);
            $company->users()->save($model);


            $newGroupKeys = $groups->pluck('key')->toArray();
            $model->groups()->attach($newGroupKeys);


            $newLocationKeys = $locations->pluck('key')->toArray();
            $model->locations()->attach($newLocationKeys);


            // RecognitionBiometricRecord

            // $socketMatcher = new MatcherFingerService($company->key, 'Users');
            // $response = $socketMatcher->store($model->id, $model->name, $model->email, $terminal->key);

            // //Validación de conexion
            // if (!$response['success']) {
            //     $model->delete();
            //     throw new Exception(implode(", ", $response['messages']));
            // }

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    public function update(Request $request, $id)
    {
        try {


            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $input = $request->all();
            $validator = $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails())
                return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            BiometricsUtilities::isValideLocations($input['locationKeys']);

            $model = $modelClass::find($id);

            if (empty($model))
                return $this->sendError('Not Found', 'No se encontro registro', 404);

            $terminal = BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);

            if (empty($terminal))
                return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);

            $groups = Group::whereIn('key', $input['groupKeys'])->project(['key' => 1, 'terminal_key' => 1])->get();

            if (empty($groups))
                return $this->sendError('Not Found group', 'No se encontraron Grupos', 404);

            $locations = Location::whereIn('key', $input['locationKeys'])->project(['key' => 1, 'name' => 1])->get();

            if (empty($locations))
                return $this->sendError('Not Found group', 'No se encontraron Sucursales', 404);

            // Valide duplicate email
            if (QueryUtilities::isDuplicateRecord($model, 'email', $input['email'], $id))
                return $this->sendError('Error de validacion', "The email " . $input['email'] . " has already been taken.", 422);


            $model->fill($input);

            $parentRelation = config('registry.user.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass = $parentRelation['related'];
                $model->parentModelKey = $parentRelation['otherKey'];
                $model->parentModelIndex = $input['parentModelIndex'];
            }

            $currentLocationKeys = $model->locations()->pluck('key')->toArray();
            $newLocationKeys = $locations->pluck('key')->toArray();

            // Calcular la diferencia: claves que están en `currentLocationKeys` pero no en `newLocationKeys`
            $removedLocationKeys = array_diff($currentLocationKeys, $newLocationKeys);

            $model->biometricRecords()
                ->whereIn('location_key', $removedLocationKeys)
                ->whereIn('syncStatus', [SyncStatus::PENDING, SyncStatus::ERROR])
                ->delete();

            $model->biometricRecords()
                ->whereIn('location_key', $removedLocationKeys)
                ->where('syncStatus', SyncStatus::SYNCHRONIZED)
                ->update(['syncStatus' => SyncStatus::DELETING]);



            // Calcular la diferencia: claves que están en `newLocationKeys` pero no en `currentLocationKeys`
            $addedLocationKeys = array_diff($newLocationKeys, $currentLocationKeys);

            // dispatch(new UpdatedBiometricRecord($model, $addedLocationKeys));

            $bimetricModels = [];

            $model->fingerprints()->get()->each(function ($fingerprint) use (&$bimetricModels) {
                $bimetricModels[] = $fingerprint;
            });

            $model->faces()->get()->each(function ($face) use (&$bimetricModels) {
                $bimetricModels[] = $face;
            });

            dd($bimetricModels,$addedLocationKeys ,  $locations);





            $currentGroupKeys = $model->groups()->pluck('key')->toArray();
            $newGroupKeys = $groups->pluck('key')->toArray();





            $model->groups()->detach();
            $model->groups()->attach($newGroupKeys);
            $model->group_keys = $newGroupKeys;


            // Actualizar el campo location_keys dentro del usuario
            $model->locations()->detach();
            $model->locations()->attach($newLocationKeys);
            $model->location_keys = $newLocationKeys;


            $model->save();

            dispatch(new UpdatedBiometricRecord($model, $addedLocationKeys));

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::find($id);

            $shortName = $this->reflectionClassModel->getShortName();
            $data = [];

            if (empty($model))
                throw new Exception($shortName . ' not found', 404);

            $model->groups()->detach();
            $model->locations()->detach();

            $data[$shortName] = (int) $model->delete();
            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }



    /**
     * Display faces by User.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function faces($id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::find($id);
            $shortName = $this->reflectionClassModel->getShortName();

            if (empty($model))
                throw new Exception($shortName . ' not found', 404);

            $faces = $model->faces;

            return $this->sendResponse($faces, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }



    /**
     * Display fingerprint by User.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function fingerprints($id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::find($id);
            $shortName = $this->reflectionClassModel->getShortName();

            if (empty($model))
                throw new Exception($shortName . ' not found', 404);

            $fingerprints = $model->fingerprints;

            return $this->sendResponse($fingerprints, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }

}
