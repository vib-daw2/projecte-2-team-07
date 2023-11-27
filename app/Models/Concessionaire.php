<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionaire extends Model
{
    public $timestamps = true;
    use HasFactory;
    protected $fillable = ['name','phone_number','email','address','coordinates','picture'];

    public function customers()
    {
        return $this->belongsToMany(
                Customer::class,
                'concessionaire_customer');     
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
