<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("accounts")->insert([
            "client_id" => 1,
            "currency" => "EUR",
            "balance" => 100
        ]);
        DB::table("accounts")->insert([
            "client_id" => 2,
            "currency" => "USD",
        ]);
        DB::table("accounts")->insert([
            "client_id" => 2,
            "currency" => "EUR",
        ]);
    }
}
