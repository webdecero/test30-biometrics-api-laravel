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

        Schema::create('faces', function (Blueprint $collection) {

            $collection->index('user_id');
            $collection->index('terminal_key');


        });

    }


};
