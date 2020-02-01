<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vehicle;
use App\EmployeeGroup;
use App\Payment;
class CustomerRequest extends Model
{
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function employeegroup()
    {
        return $this->belongsTo(EmployeeGroup::class);
    }

    public function price()
    {
        return $this->belongsTo(Payment::class);
    }

}
