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
        Schema::table('client_subscriptions', function (Blueprint $table) {
            $table->foreignId('onlinepayment_id')->nullable()->constrained('online_payments');
            $table->enum('subscription_method', ['online', 'activation_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_subscriptions', function (Blueprint $table) {
            $table->dropColumn('onlinepayment_id');
            $table->dropColumn('subscription_method');
        });
    }
};
