<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("clients")->insert([
            "name" => "Jānis",
            "surname" => "Bērziņš",
            "country" => "Latvia"
        ]);
        DB::table("clients")->insert([
            "name" => "Pēteris",
            "surname" => "Ozoliņš",
            "country" => "Latvia"
        ]);
        DB::table("clients")->insert([
            "name" => "Aigars",
            "surname" => "Liepiņš",
            "country" => "Latvia"
        ]);
    }
}
