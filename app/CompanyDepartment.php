<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    protected $fillable = ['name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
