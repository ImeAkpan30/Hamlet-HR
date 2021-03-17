<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        "user_id",
        "reference",
        "currency",
        "type",
        "type_id",
        "channel",
        "amount",
        "status",
        "gateway",
        "transaction_date"
    ];
}
