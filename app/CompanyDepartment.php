<?php

namespace App;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = ['name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
