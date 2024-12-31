<?php

namespace App\Http\Controllers\Registry;



use Exception;

use App\Models\User;
use MongoDB\BSON\Binary;
use App\Enums\SyncStatus;


use MongoDB\BSON\ObjectId;
use App\Enums\TerminalType;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BiometricRecord;
use App\Jobs\CreateBiometricRecord;
use App\Jobs\DeleteBiometricRecord;
use Illuminate\Support\Facades\Storage;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;
use App\Http\Services\ApiTerminalsWebsocket\RecognitionTerminalsClient;

class FingerprintController extends AbstractCoreController
{
    private $_biometricsDisk;

    private $_prefixPath;
    protected $prefix = 'fingerprints';
    protected $company = null;


    public function __construct()
    {

        $this->_biometricsDisk = Storage::disk('biometrics');

        $this->_prefixPath = $this->_biometricsDisk->getConfig()['prefixPath'] ?? 'biometrics';

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.fingerprint');
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

            $isDuplicate = $user->fingerprints()
                ->where('typeHand', $input['typeHand'])
                ->where('typeFinger', $input['typeFinger'])
                ->first();

            if (!empty($isDuplicate))
                return $this->sendError('finger_duplicade', 'Este dedo ya se encuentre registrado', 400);



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
                ((string) $model->id) . '_image_' . $input['typeHand'] . '_' . $input['typeFinger'] . '.jpg'
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
                ((string) $model->id) . '_template_' . $input['typeHand'] . '_' . $input['typeFinger'] . '.bit'
            );
            $model->template = $this->_prefixPath . DIRECTORY_SEPARATOR . $pathTemplateFingerPrint;
            $model->templateBinary = new Binary($template->getContent(), Binary::TYPE_GENERIC);
            $model->templateMetadata = [
                'mimeType' => $template->getClientMimeType(),
                'size' => $template->getSize(),
            ];

            $model->save();
            $user->fingerprints()->save($model);


            //////////////////////// Sync ////////////////////////

            dispatch(new CreateBiometricRecord($model));

            // $user = $model->user;
            // $company = $user->company;
            // $locations = $user->locations;


            // $newRecords = [];
            // $syncTerminals = [];


            // foreach ($locations as $location) {
            //     $terminals = BiometricsUtilities::getTerminalsByLocation($location);

            //     foreach ($terminals as $terminal) {

            //         $record = BiometricsUtilities::createRecognitionRecord($model, $user, $terminal, $location, $company);

            //         $newRecords[] = (array) $record;
            //         $syncTerminals[$terminal->terminalType->value][]=[
            //             "id" => (string) $record->_id,
            //             "user_id" => $record->user_id,
            //             "userRecordId" => $record->userRecordId,

            //             "terminalType" => $record->terminalType->value,
            //             "terminal_key" => $record->terminal_key,
            //             "location_key" => $record->location_key,

            //            "fingerprint_id" => $record->fingerprint_id ?? '',
            //             "face_id" => $record->face_id ?? '',
            //             "card_id" => $record->card_id ?? '',
            //             "password_id" => $record->password_id ?? '',

            //             "biometricType" => $record->biometricType->value,
            //             "backupNum" => $record->backupNum,
            //             "syncStatus" => $record->syncStatus->value,
            //         ];

            //     }

            // }
            // if (empty($newRecords))
            // return;

            // BiometricRecord::insert($newRecords);


            // $recognitonTerminals = $syncTerminals[TerminalType::RECOGNITION->value]??[];

            // $torniquetTerminals = $syncTerminals[TerminalType::TORNIQUET->value]??[];
            // $kioskTerminals = $syncTerminals[TerminalType::KIOSK->value]??[];

            // $responseRecogniton = (new RecognitionTerminalsClient())->sync($recognitonTerminals);

            // dd($responseRecogniton);


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
