<?php

namespace Hamlet\Modules;

use Illuminate\Support\Str;
use \Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public $incrementing = false;


    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid();

        });
    }
}
