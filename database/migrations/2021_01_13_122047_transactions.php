<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sender_account_id");
            $table->unsignedBigInteger("receiver_account_id");
            $table->float("exchange_rate")->default(null)->nullable();
            $table->float("transfer_amount");
            $table->timestamp("datetime")->useCurrent();
            $table->foreign("sender_account_id")->references("id")->on("accounts");
            $table->foreign("receiver_account_id")->references("id")->on("accounts");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("transactions");
    }
}
