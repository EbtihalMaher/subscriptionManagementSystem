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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description');
            $table->double('price');
            $table->integer('duration');
            $table->string('duration_unit')->comment('d=days,m=monthes,y=years');
            $table->tinyInteger('is_unlimited')->default('0')->comment('0=limited,1=unlimited');
            $table->tinyInteger('limit')->nullable();
            $table->string('image' );
//            $table->tinyInteger('active')->default('0')->comment('0=inactive,1=active');
            $table->unsignedInteger('enterprise_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
