<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Enums\TerminalType;
use Illuminate\Bus\Batchable;

use App\Models\BiometricRecord;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Http\Utilities\BiometricsUtilities;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\ApiTerminalsWebsocket\RecognitionTerminalsClient;


class CreateBiometricRecord implements ShouldQueue
{

    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private Model $model;

    public $timeout = 30;


    /**
     * Create a new job instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            /**
             * TODO: CreateFingerprintRecord
             * Ajustar algoritmo para verificar excluciones
             *
             */

            $this->model->attempts = $this->attempts();
            $model = $this->model;

            $user = $model->user;
            $company = $user->company;
            $locations = $user->locations;

            $newRecords = [];
            $syncTerminals = [];


            foreach ($locations as $location) {
                $terminals = BiometricsUtilities::getTerminalsByLocation($location);

                foreach ($terminals as $terminal) {

                    $record = BiometricsUtilities::createRecognitionRecord($model, $user, $terminal, $location, $company);

                    $newRecords[] = (array) $record;
                    $syncTerminals[$terminal->terminalType->value][]=[
                        "id" => (string) $record->_id,
                        "user_id" => $record->user_id,
                        "userRecordId" => $record->userRecordId,

                        "terminalType" => $record->terminalType->value,
                        "terminal_key" => $record->terminal_key,
                        "location_key" => $record->location_key,

                       "fingerprint_id" => $record->fingerprint_id ?? '',
                        "face_id" => $record->face_id ?? '',
                        "card_id" => $record->card_id ?? '',
                        "password_id" => $record->password_id ?? '',

                        "biometricType" => $record->biometricType->value,
                        "backupNum" => $record->backupNum,
                        "syncStatus" => $record->syncStatus->value,
                    ];

                }

            }
            if (empty($newRecords))
            return;

            BiometricRecord::insert($newRecords);

            /**
             * TODO: Crear registro Request para sincronizar terminales
             *
             */

            $recognitonTerminals = $syncTerminals[TerminalType::RECOGNITION->value]??[];

            $torniquetTerminals = $syncTerminals[TerminalType::TORNIQUET->value]??[];
            $kioskTerminals = $syncTerminals[TerminalType::KIOSK->value]??[];

            $responseRecogniton = (new RecognitionTerminalsClient())->sync($recognitonTerminals);

            $this->model->responseRecogniton = $responseRecogniton;
            $this->model->save();

        } catch (\Throwable $th) {
            $this->model->errorSync = $th->getMessage();
            $this->model->save();
        }
    }







    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->model->errorSync = '[' . Carbon::now()->toDateTimeString() . '] ' . $exception->getMessage();
        $this->model->save();
    }
}
