<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('biometric_records', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('syncStatus');
            $collection->index('biometricType');
            $collection->index('terminalDeviceId');
            $collection->index(['fingerprint_id' => -1]);
            $collection->index(['face_id' => -1]);
            $collection->index([
                'terminalDeviceId' => 1,
                'userRecordId' => -1,
                'backupNum' => 1,
                'terminalType' => 1,

            ], 'recognition_record_index');
            $collection->index([
                'terminal_key' => 1,
                'terminalDeviceId' => 1,
                'terminalType' => 1,

            ], 'terminal_key_index');
            $collection->index([
                'location_key' => 1,
                'terminalDeviceId' => 1,
                'terminalType' => 1,

            ], 'location_key_index');
        });

    }


};
