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

        Schema::create('registry_terminals', function (Blueprint $collection) {
            $collection->unique('key');
            $collection->index('deviceId');
            $collection->index('location_key');
            $collection->index('features');


        });

    }


};
