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
        Schema::create('jobs', function (Blueprint $collection) {
            // reserved_at_-1
            $collection->index(['reserved_at' => -1]);
            // available_at_1_reserved_1
            $collection->index(['available_at' => -1, 'reserved' => 1]);
        });

        Schema::create('job_batches', function (Blueprint $collection) {

            // failed_job_ids_1
            $collection->index(['failed_job_ids' => 1]);

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('jobs');
        // Schema::dropIfExists('job_batches');
    }
};
