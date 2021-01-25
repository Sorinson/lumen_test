<?php

class AccountTest extends TestCase
{
    public function testAccountInfo()
    {
        $this->artisan("migrate:fresh --seed");

        $this->json("GET", "/account/1")->seeJsonEquals([
            "id"=> 1,
            "client_id"=> 1,
            "currency"=> "EUR",
            "balance"=> "100"
        ]);
        $this->json("GET", "/account/2")->seeJsonEquals([
            "id"=> 2,
            "client_id"=> 2,
            "currency"=> "USD",
            "balance"=> "0"
        ]);
        $this->json("GET", "/account/3")->seeJsonEquals([
            "id"=> 3,
            "client_id"=> 2,
            "currency"=> "EUR",
            "balance"=> "0"
        ]);

        $this->json("GET", "/account/1,1")->seeStatusCode(400);
        $this->json("GET", "/account/1.1")->seeStatusCode(400);
        $this->json("GET", "/account/@")->seeStatusCode(400);
        $this->json("GET", "/account/a")->seeStatusCode(400);
        $this->json("GET", "/account/1a")->seeStatusCode(400);
        $this->json("GET", "/account/1a1")->seeStatusCode(400);
        $this->json("GET", "/account/*")->seeStatusCode(400);

    }

    public function testAccountHistory()
    {
        $this->json("GET", "/account/1/history?offset=5&limit=10", [
            "offset" => 0,
            "limit" => 10
        ])->seeJsonEquals([
            "limit"=> 10,
            "offset"=> 0,
            "total"=> 0,
            "history"=> []
        ]);
    }
}
