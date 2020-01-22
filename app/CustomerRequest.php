<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vehicle;
class CustomerRequest extends Model
{
    //
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
