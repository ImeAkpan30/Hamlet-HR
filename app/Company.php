<?php

namespace App;

use App\User;
use App\CompanyDepartment;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'company_name', 'company_email', 'company_address', 'company_phone', 'no_of_employees', 'city', 'state', 'zip_code',
        'company_website', 'company_logo', 'services'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyDepartments()
    {
        return $this->hasMany(CompanyDepartment::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
