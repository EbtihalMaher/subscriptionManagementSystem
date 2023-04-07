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
        Schema::create('activation_codes_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('package_id');
            $table->string('group_name', 50);
            $table->unsignedInteger('count');
            $table->date('start_date');
            $table->date('expire_date');
            $table->double('price');
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
        Schema::dropIfExists('activation_codes_groups');
    }
};
