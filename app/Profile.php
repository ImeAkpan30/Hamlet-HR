<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = ['first_name', 'last_name', 'address', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

