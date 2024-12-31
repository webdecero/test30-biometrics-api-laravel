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

        Schema::create('users', function (Blueprint $collection) {
            $collection->unique('email', options: ['name' => 'unique_email']);
            $collection->index([
                'email' => 1,
                'status' => 1,

            ], 'login_index');

            $collection->index('name');
            $collection->index('scopes');
            $collection->index('parentModelKey');

            $collection->index('group_keys');
            $collection->index('location_keys');


        });

    }


};
