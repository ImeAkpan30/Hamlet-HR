<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $fillable = [
        'employment_type',
        'job_title',
        'salary',
        'date_hired',
        'description',
        'department',
        'employment_classification',
        'job_category',
        'work_location'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
