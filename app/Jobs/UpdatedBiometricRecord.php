<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\User;

use App\Enums\TerminalType;
use Illuminate\Bus\Batchable;
use App\Models\BiometricRecord;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Http\Utilities\BiometricsUtilities;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\ApiTerminalsWebsocket\RecognitionTerminalsClient;


class UpdatedBiometricRecord implements ShouldQueue
{

    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public $timeout = 30;


    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private $locations
    )
    {

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
             * crear un clon de los registros de huellas y faces
             *
             */

            $user = $this->user;
            $user->attempts = $this->attempts();

            $company = $user->company;
            $locations = $this->locations;

            $newRecords = [];
            $syncTerminals = [];
            $bimetricModels = [];

            $user->fingerprints()->get()->each(function ($fingerprint) use (&$bimetricModels) {
                $bimetricModels[] = $fingerprint;
            });

            $user->faces()->get()->each(function ($face) use (&$bimetricModels) {
                $bimetricModels[] = $face;
            });

            dd($bimetricModels, $locations);


            foreach ($bimetricModels as $key => $bimetricModel) {
                # code...
            }


            foreach ($locations as $location) {
                $terminals = BiometricsUtilities::getTerminalsByLocation($location);

                foreach ($terminals as $terminal) {

                    $record = BiometricsUtilities::createRecognitionRecord( $bimetricModel, $user, $terminal, $location, $company);

                //     $newRecords[] = (array) $record;
                //     $syncTerminals[$terminal->terminalType->value][]=[
                //         "id" => (string) $record->_id,
                //         "user_id" => $record->user_id,
                //         "userRecordId" => $record->userRecordId,

                //         "terminalType" => $record->terminalType->value,
                //         "terminal_key" => $record->terminal_key,
                //         "location_key" => $record->location_key,

                //        "fingerprint_id" => $record->fingerprint_id ?? '',
                //         "face_id" => $record->face_id ?? '',
                //         "card_id" => $record->card_id ?? '',
                //         "password_id" => $record->password_id ?? '',

                //         "biometricType" => $record->biometricType->value,
                //         "backupNum" => $record->backupNum,
                //         "syncStatus" => $record->syncStatus->value,
                //     ];

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

            $this->user->responseRecogniton = $responseRecogniton;
            $this->user->save();

        } catch (\Throwable $th) {
            $this->user->errorSync = $th->getMessage();
            $this->user->save();
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
        $this->user->errorSync = '[' . Carbon::now()->toDateTimeString() . '] ' . $exception->getMessage();
        $this->user->save();
    }
}
