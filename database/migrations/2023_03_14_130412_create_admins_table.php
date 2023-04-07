<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};

// CREATE TABLE admins (
//     id BIGINT(8) UNSIGNED AUTO_INCREMENT,
//     name VARCHAR(50) NOT NULL,
//     email VARCHAR(50) NOT NULL UNIQUE,
//     password VARCHAR(100) NOT NULL,
//     gender ENUM('M','F') NOT NULL DEFAULT 'M',
//     PRIMARY KEY (id)
//   );