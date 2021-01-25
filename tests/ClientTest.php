<?php


class ClientTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccountInfo()
    {
        $this->artisan("migrate:fresh --seed");

        $this->json("GET", "/client/1")->seeJsonEquals([
            "id" => 1,
            "info" => [
                "name" => "Jānis",
                "surname" => "Bērziņš",
                "country" => "Latvia"
            ],
            "accounts" => [
                [
                    "id" => 1,
                    "client_id" => 1,
                    "currency" => "EUR",
                    "balance" => "100"
                ]
            ]
        ]);

        $this->json("GET", "/client/2")->seeJsonEquals([
            "id" => 2,
            "info" => [
                "name" => "Pēteris",
                "surname" => "Ozoliņš",
                "country" => "Latvia"
            ],
            "accounts" => [
                [
                    "id" => 2,
                    "client_id" => 2,
                    "currency" => "USD",
                    "balance" => "0"
                ],
                [
                    "id" => 3,
                    "client_id" => 2,
                    "currency" => "EUR",
                    "balance" => "0"
                ]
            ]
        ]);

        $this->json("GET", "/client/3")->seeJsonEquals([
            "id" => 3,
            "info" => [
                "name" => "Aigars",
                "surname" => "Liepiņš",
                "country" => "Latvia"
            ],
            "accounts" => []
        ]);
    }
}
