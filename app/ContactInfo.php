<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = ['phone', 'email', 'emergency_contact'];

        public function employee(){
            return $this->belongsTo(Employee::class);
        }
}
