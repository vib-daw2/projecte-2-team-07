<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone_number','email','address','user_id'];

    public function concessionaires()
    {
        return $this->belongsToMany(
                Concessionaire::class,
                'concessionaire_customer');     
    }   
}
