<?php

namespace App;

use App\User;
use App\Company;
use App\Employee;
use App\JobDetail;
use App\ContactInfo;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['first_name', 'other_names', 'gender', 'dob', 'address', 'city', 'qualification'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobDetails()
    {
        return $this->hasOne(JobDetail::class);
    }

    public function contactInfo()
    {
        return $this->hasOne(ContactInfo::class);
    }
}
