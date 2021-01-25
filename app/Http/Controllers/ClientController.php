<?php


namespace App\Http\Controllers;


use App\Models\Client;

class ClientController extends Controller
{
    public function view($id): array
    {
        $client = Client::find($id);
        if(!$client){
            abort(404, "Client not found");
        }
        return [
            "id" => $client->id,
            "info" => [
                "name" => $client->name,
                "surname" => $client->surname,
                "country" => $client->country
            ],
            "accounts" => $client->accounts
        ];
    }
}
