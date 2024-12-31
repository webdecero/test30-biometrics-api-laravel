<?php

namespace App\Http\Controllers\Registry;



use Exception;
use App\Models\User;
use MongoDB\BSON\Binary;
use App\Enums\SyncStatus;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\CreateBiometricRecord;
use App\Jobs\DeleteBiometricRecord;
use Illuminate\Support\Facades\Storage;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class FaceController extends AbstractCoreController
{
    private $_biometricsDisk;

    private $_prefixPath;
    protected $prefix = 'faces';
    protected $company = null;


    public function __construct()
    {

        $this->_biometricsDisk = Storage::disk('biometrics');

        $this->_prefixPath = $this->_biometricsDisk->getConfig()['prefixPath'] ?? 'biometrics';

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.face');
    }



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


            $user = User::findOrFail($input['userId']);

            $terminal = BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);

            if (empty($terminal))
                return $this->sendError('Not Found Terminal', 'No se encontro terminal ' . $input['terminalKey'], 404);

            $count = $user->faces()->count();

            if ($count >= 3)
                return $this->sendError('face_max', 'Número maximo de rostros superado.', 400);



            $model->_id = new ObjectId();
            $model->fill($input);
            $model->userName = $user->name;
            $model->terminal_key = $terminal->key;
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->terminalType;

            $pathStore = $this->prefix . DIRECTORY_SEPARATOR . $user->id;

            //Crea registro image
            $image = $request->file('image');
            $pathImageFingerPrint = $this->_biometricsDisk->putFileAs(
                $pathStore,
                $image,
                ((string) $model->id) . '_image.jpg'
            );

            $model->image = $this->_prefixPath . DIRECTORY_SEPARATOR . $pathImageFingerPrint;
            $model->imageBinary = new Binary($image->getContent(), Binary::TYPE_GENERIC);
            $model->imageMetadata = [
                'mimeType' => $image->getClientMimeType(),
                'size' => $image->getSize(),
            ];

            //Crea registro template
            $template = $request->file('template');
            $pathTemplateFingerPrint = $this->_biometricsDisk->putFileAs(
                $pathStore,
                $template,
                ((string) $model->id) . '_template.bit'
            );
            $model->template = $this->_prefixPath . DIRECTORY_SEPARATOR . $pathTemplateFingerPrint;
            $model->templateBinary = new Binary($template->getContent(), Binary::TYPE_GENERIC);
            $model->templateMetadata = [
                'mimeType' => $template->getClientMimeType(),
                'size' => $template->getSize(),
            ];

            $model->save();
            $user->faces()->save($model);


            //////////////////////// Sync ////////////////////////

            dispatch(new CreateBiometricRecord($model));


            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }


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

            $data[$shortName] = (int) $model->delete();
            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }

}
