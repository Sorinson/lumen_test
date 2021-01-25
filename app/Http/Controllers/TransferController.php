<?php


namespace App\Http\Controllers;



use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function create(Request $request): array
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            abort(400, "Incorrect request method");
        }
        $transfer_amount = round(str_replace(",", ".", $request->input("transfer_amount")), 2);
        $sender_account_id = $request->post("sender_account_id");
        $receiver_account_id = $request->post("receiver_account_id");
        $transaction_id = app("db")->transaction(function() use ($transfer_amount, $sender_account_id, $receiver_account_id){
            $sender_account = Account::lockForUpdate()->find($sender_account_id);
            if(!$sender_account){
                abort(404, "Sender account not found");
            }
            if($sender_account->balance < $transfer_amount){
                abort(400, "Insufficient funds");
            }

            $receiver_account = Account::lockForUpdate()->find($receiver_account_id);
            if(!$receiver_account){
                abort(404, "Receiver account not found");
            }

            if($sender_account->currency != $receiver_account->currency){
                $exchange_rate = json_decode(
                    file_get_contents(
                        "https://api.exchangerate.host/convert?from=". $sender_account->currency .
                        "&to=". $receiver_account->currency .
                        "&amount=". $transfer_amount
                    )
                );
                $converted_amount = round($exchange_rate->result, 2);
                $exchange_rate = $exchange_rate->info->rate;
                $sender_account->decrement("balance", $transfer_amount);
                $receiver_account->increment("balance", $converted_amount);
                $transaction = new Transaction([
                    "sender_account_id" => $sender_account->id,
                    "receiver_account_id" => $receiver_account->id,
                    "transfer_amount" => $transfer_amount,
                    "exchange_rate" => $exchange_rate
                ]);
            }else{
                $sender_account->decrement("balance", $transfer_amount);
                $receiver_account->increment("balance", $transfer_amount);
                $transaction = new Transaction([
                    "sender_account_id" => $sender_account->id,
                    "receiver_account_id" => $receiver_account->id,
                    "transfer_amount" => $transfer_amount
                ]);
            }
            if($transaction->save()){
                return $transaction->id;
            }else{
                return false;
            }
        });

        if(!$transaction_id){
            abort(400, "Transaction failed");
        }
        return [
            "transaction_id" => $transaction_id
        ];
    }
}
