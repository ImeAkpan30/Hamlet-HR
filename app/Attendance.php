<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['attendance_status', 'date'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
