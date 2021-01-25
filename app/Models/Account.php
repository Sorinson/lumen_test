<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    public function client(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Client::class);
    }
}
