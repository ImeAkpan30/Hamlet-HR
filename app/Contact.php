<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['firstname', 'lastname', 'email', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
