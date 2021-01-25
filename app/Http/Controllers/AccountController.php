<?php


namespace App\Http\Controllers;


use App\Models\Account;
use App\Models\Transaction;
use FastRoute\Route;
use Laravel\Lumen\Http\Request;

class AccountController extends Controller
{
    public function view($id): array
    {
        $account = Account::find($id);
        if(!$account){
            abort(404, "Account not found");
        }
        return [
            "id" => $account->id,
            "client_id" => $account->client_id,
            "currency" => $account->currency,
            "balance" => $account->balance,
        ];
    }
    public function history($id): array
    {
        $request = app("request")->request;
        $offset = $request->get("offset", 0);
        $limit = $request->get("limit", 10);
        $transactions = Transaction::where("sender_account_id", $id)
            ->orWhere("receiver_account_id", $id)
            ->orderBy("datetime", "DESC");

        return [
            "limit" => $limit,
            "offset" => $offset,
            "total" => $transactions->count(),
            "history" => $transactions->limit($limit)->offset($offset)->get()
        ];
    }
}
