<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = ['phone', 'email', 'emergency_contact'];

        public function employee()
        {
            return $this->belongsTo(Employee::class);
        }
}
