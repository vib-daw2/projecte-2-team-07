<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function concessionaire() {
        return $this->belongsTo(Concessionaire::class, 'concessionaire_id');
    }
}
