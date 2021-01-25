<?php


class TransferTest extends TestCase
{
    public function testTransfer()
    {
        $this->artisan("migrate:fresh --seed");
        $this->json("GET", "/account/1")->seeJsonEquals([
            "id"=> 1,
            "client_id"=> 1,
            "currency"=> "EUR",
            "balance"=> "100"
        ]);
        $this->json("GET", "/account/3")->seeJsonEquals([
            "id"=> 3,
            "client_id"=> 2,
            "currency"=> "EUR",
            "balance"=> "0"
        ]);


        $transfer = $this->post("/transfer", [
                "sender_account_id" => 1,
                "receiver_account_id" => 3,
                "transfer_amount" => "14"
        ]);
        $transfer->response->assertExactJson([
            "transaction_id"=> 1
        ]);

        $this->json("GET", "/account/1")->seeJsonEquals([
            "id"=> 1,
            "client_id"=> 1,
            "currency"=> "EUR",
            "balance"=> "86"
        ]);
        $this->json("GET", "/account/3")->seeJsonEquals([
            "id"=> 3,
            "client_id"=> 2,
            "currency"=> "EUR",
            "balance"=> "14"
        ]);
    }
}
