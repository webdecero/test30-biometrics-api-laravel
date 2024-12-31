<?php

namespace App\Http\Utilities;


use stdClass;

use Exception;
use App\Models\User;
use ReflectionClass;
use App\Models\Kiosk;
use App\Enums\HandTypes;
use App\Models\Location;
use App\Models\Registry;
use App\Enums\SyncStatus;
use App\Models\Torniquet;
use App\Enums\FingerTypes;
use MongoDB\BSON\ObjectId;
use App\Enums\TerminalType;
use App\Enums\BiometricType;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use MongoDB\Laravel\Eloquent\Model;


class BiometricsUtilities
{

    public static function valideParentRelation($parentModelIndex, $parentRelation = null)
    {

        if (!isset($parentRelation['related']) || empty($parentRelation['related']))
            throw new Exception('Not found parentRelation related', 422);

        $model = new ReflectionClass($parentRelation['related']);
        if (!$model->newInstance() instanceof Model)
            throw new Exception($parentRelation['related'] . "  is not instance of MongoDB\Laravel\Eloquent\Model");


        if (!isset($parentRelation['foreignKey']) || empty($parentRelation['foreignKey']))
            throw new Exception('Not found parentRelation foreignKey', 422);

        if (!isset($parentRelation['otherKey']) || empty($parentRelation['otherKey']))
            throw new Exception('Not found parentRelation otherKey', 422);


        $relationModel = $parentRelation['related'];

        $relationRegistry = $relationModel::where($parentRelation['otherKey'], $parentModelIndex)->first();

        if (empty($relationRegistry))
            throw new Exception("Not Found relationRegistry " . $parentRelation['related'] . " whith " . $parentModelIndex, 404);
    }

    public static function isValideLocations($locationsKeys): bool
    {

        foreach ($locationsKeys as $location) {

            $terminal = Location::where('key', $location)->first();

            if (empty($terminal))
                throw new Exception("Not found location {$location}", 404);
        }

        return true;
    }

    public static function getTerminalByType(string $terminalKey, TerminalType|string $terminalType, $key = 'key'): Model
    {

        $terminal = null;

        $terminalType = is_string($terminalType) ? TerminalType::tryFrom($terminalType) : $terminalType;


        switch ($terminalType) {
            case TerminalType::KIOSK:
                $terminal = Kiosk::where($key, $terminalKey)->first();
                break;
            case TerminalType::REGISTRY:

                $terminal = Registry::where($key, $terminalKey)->first();

                break;
            case TerminalType::TORNIQUET:
                $terminal = Torniquet::where($key, $terminalKey)->first();
                break;
        }

        if (empty($terminal))
            throw new Exception("Not found terminal:{$terminalKey}", 404);

        return $terminal;
    }

    public static function getValueFinger(string $hand, string $finger)
    {
        $value = 0;
        switch ($finger) {
            case 'thumb':
                $value = 1;
                break;
            case 'index':
                $value = 2;
                break;
            case 'middle':
                $value = 3;
                break;
            case 'ring':
                $value = 4;
                break;
            case 'little':
                $value = 5;
                break;
        }
        switch ($hand) {
            case 'right':
                $value += 0;
                break;
            case 'left':
                $value += 5;
                break;
        }

        return $value;

    }

    /**
     * Genera el backupnum a partir de un registro de MongoDB\Laravel\Eloquent\Model.
     *
     * @param Model $record
     * @return int
     * @throws InvalidArgumentException
     */
    public static function getBackupNum(Model $record): int
    {
        // Validar que el registro tenga los campos necesarios
        if (!isset($record->biometricType)) {
            throw new InvalidArgumentException("El campo 'biometricType' es obligatorio.");
        }


        switch ($record->biometricType) {
            case BiometricType::FACE:

                return 50; // Valor genérico para FACE (puedes personalizarlo)

            case BiometricType::FINGERPRINT:
                // Validar que el registro contenga `typeHand` y `typeFinger`
                if (!isset($record->typeHand) || !isset($record->typeFinger)) {
                    throw new InvalidArgumentException("Los campos 'typeHand' y 'typeFinger' son obligatorios para huellas digitales.");
                }

                // Mapeo de dedos a valores base
                $fingerMap = [
                    FingerTypes::THUMB->value => 0,
                    FingerTypes::INDEX->value => 1,
                    FingerTypes::MIDDLE->value => 2,
                    FingerTypes::RING->value => 3,
                    FingerTypes::LITTLE->value => 4,
                ];

                // Asignar un valor base según la mano
                $handOffset = $record->typeHand === HandTypes::LEFT ? 0 : 5;

                // Calcular el backupnum combinando la mano y el dedo
                return $handOffset + $fingerMap[$record->typeFinger->value];

            case BiometricType::CARD:
                // Valores predeterminados para tarjetas RFID
                return 11; // Ejemplo

            case BiometricType::PASSWORD:
                // Valores predeterminados para contraseñas
                return 10; // Ejemplo

            default:
                throw new InvalidArgumentException("Tipo biométrico no soportado.");
        }
    }



    /**
     * Genera el backupnum a partir de un registro de MongoDB\Laravel\Eloquent\Model.
     *
     * @param Model $record
     * @return int
     * @throws InvalidArgumentException
     */
    public static function createRecognitionRecord(Model $bimetricModel, User $user, $terminal, $location, $company): stdClass
    {

        $record = new stdClass();

        $record->_id = new ObjectId();
        $record->user_id = $user->id;
        $record->userRecordId = $user->recordId;
        $record->userName = $user->name;

        $record->terminal_key = $terminal->key;
        $record->terminalName = $terminal->name;
        $record->terminalType = $terminal->terminalType;
        $record->terminalDeviceId = $terminal->deviceId;
        $record->terminalBrand = $terminal->brand;
        $record->terminalModelName = $terminal->modelName;

        $record->location_key = $location->key;
        $record->locationName = $location->name;

        $record->company_key = $company->key;
        $record->companyName = $company->name;

        $record->biometricType = $bimetricModel->biometricType;

        switch ($record->biometricType) {
            case BiometricType::FINGERPRINT:
                $record->fingerprint_id = $bimetricModel->id;
                break;
            case BiometricType::FACE:
                $record->face_id = $bimetricModel->id;
                break;
            case BiometricType::CARD:
                $record->card_id = $bimetricModel->id;
                break;
            case BiometricType::PASSWORD:
                $record->password_id = $bimetricModel->id;
                break;
            default:
                throw new InvalidArgumentException("Tipo biométrico no soportado.");
        }

        $record->templateFormat = $bimetricModel->templateFormat;
        $record->templateBinary = $bimetricModel->templateBinary;
        $record->imageBinary = $bimetricModel->imageBinary;
        $record->backupNum = BiometricsUtilities::getBackupNum($bimetricModel);


        $record->syncStatus = SyncStatus::PENDING;
        $record->created_at = now();

        return $record;

    }

    public static  function getTerminalsByLocation($location): Collection
    {
        $terminals = collect();
        $terminals = $terminals->merge($location->recognitions);
        $terminals = $terminals->merge($location->kiosks);
        $terminals = $terminals->merge($location->torniquets);

        return $terminals;
    }


}
