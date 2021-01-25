<?php


namespace App\Http\Middleware;


use Closure;
use Laravel\Lumen\Http\Request;

class IntegerIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route("id");
        if($id && !ctype_digit($id)){
            abort(400, "ID must be an integer");
        }

        $gets = $request->request->all("get");

        $sender_account_id = (isset($gets["sender_account_id"])?:null);
        if($sender_account_id !== null && !ctype_digit($sender_account_id)){
            abort(400, "Account ID must be an integer");
        }

        $receiver_account_id = (isset($gets["receiver_account_id"])?:null);
        if($receiver_account_id !== null && !ctype_digit($receiver_account_id)){
            abort(400, "Account ID must be an integer");
        }

        $transfer_amount = (isset($gets["transfer_amount"])?:null);
        if($transfer_amount !== null){
            $transfer_amount = str_replace(",", ".", $transfer_amount);
            if(!is_numeric($transfer_amount)){
                abort(400, "Transfer amount must be a number.");
            }
            $transfer_amount = (float) $transfer_amount;
            if($transfer_amount <= 0){
                abort(400, "Transfer amount must be positive.");
            }
        }

        return $next($request);
    }
}
