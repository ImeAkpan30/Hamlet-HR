<?php

namespace App;

use App\Plan;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        "user_id","plan_id","duration","amount","start_at","expired_at","status"
    ];

    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function plan(){
        return $this->belongsTo(Plan::class,"plan_id");
    }

    public function scopeOfUser($query){

        if(auth()->user()->role == "admin")
            return $query;

        return $query->where("user_id", auth()->user()->id);

    }
}
