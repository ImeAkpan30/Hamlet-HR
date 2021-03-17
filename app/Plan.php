<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        "price","name","description","currency"
    ];

    public function subscriptions(){
        return $this->hasMany(Subscription::class,'plan_id');
    }
}
