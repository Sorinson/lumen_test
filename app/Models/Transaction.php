<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "sender_account_id", "receiver_account_id", "transfer_amount", "exchange_rate"
    ];

    public function senderAccount(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Account::class, "id", "sender_account_id");
    }

    public function receiverAccount(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Account::class, "id", "receiver_account_id");
    }
}
