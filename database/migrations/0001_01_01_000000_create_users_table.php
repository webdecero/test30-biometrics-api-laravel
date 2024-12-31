<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//  CREATE TABLE Users (
//     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//     SubjectId varchar(30) UNIQUE NOT NULL,
//     Template longblob NULL,
//     name varchar(60) NULL,
//     terminal_key varchar(30) NULL,
//    email varchar(30) NULL
//  );

// create table `Users` (
//     `id` bigint unsigned not null auto_increment primary key,
//     `SubjectId` varchar(255) not null,
//     `Template` blob null,
//     `name` varchar(255) not null,
//     `terminal_key` varchar(255) not null,
//     `email` varchar(255) not null,
//     `created_at` timestamp null,
//     `updated_at` timestamp null)
//     default character set utf8mb4 collate 'utf8mb4_general_ci'
//   ⇂ alter table `Users` add unique `users_subjectid_unique`(`SubjectId`)


return new class extends Migration
{

    protected $connection = 'mariadb';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->id();
            $table->string('SubjectId')->unique();
            $table->binary('Template')->nullable();
            $table->string('name')->nullable();
            $table->string('terminal_key')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('users');
    }
};
