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
        if (!Schema::hasColumn('enterprises', 'api_key')) {
            Schema::table('enterprises', function (Blueprint $table) {
                $table->string('api_key', 10)->unique();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('enterprises', 'api_key')) {
            Schema::table('enterprises', function (Blueprint $table) {
                $table->dropColumn('api_key');
            });
        }
    }
};
