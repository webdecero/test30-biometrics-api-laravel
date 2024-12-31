<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Enums\TerminalType;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\ApiTerminalsWebsocket\RecognitionTerminalsClient;


class DeleteBiometricRecord implements ShouldQueue
{

    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $records;


    public $timeout = 30;


    /**
     * Create a new job instance.
     */
    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $syncTerminals = [];

            foreach ($this->records as $record) {

                $syncTerminals[$record->terminalType->value][] = [
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


            if (empty($syncTerminals))
                return;

            $recognitonTerminals = $syncTerminals[TerminalType::RECOGNITION->value] ?? [];
            $torniquetTerminals = $syncTerminals[TerminalType::TORNIQUET->value] ?? [];
            $kioskTerminals = $syncTerminals[TerminalType::KIOSK->value] ?? [];

            /**
             * TODO:
             * En kiosk y torniquet se debe enviar un mensaje de sincronizacion
             */

            $responseRecogniton = (new RecognitionTerminalsClient())->sync($recognitonTerminals);
        } catch (\Throwable $th) {
            $error = "Message::{{$th->getMessage()} File::{$th->getFile()} Line::{$th->getLine()}";
            Log::error($error . ' [Code:' . $th->getCode() . ']');
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
        $error = 'Failed::[' . Carbon::now()->toDateTimeString() . '] ' . $exception->getMessage();
        Log::error($error);
    }
}
