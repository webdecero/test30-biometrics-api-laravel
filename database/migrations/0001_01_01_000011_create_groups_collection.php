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

        Schema::create('groups', function (Blueprint $collection) {
            $collection->unique('key');
            $collection->index('title');
            $collection->index('parentModelKey');

            $collection->index('user_ids');


        });

    }


};
