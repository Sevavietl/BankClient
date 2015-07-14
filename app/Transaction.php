<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'first_name',
        'last_name',
        'card_number',
        'card_expiration',
        'amount',
        'status',
    ];
}
