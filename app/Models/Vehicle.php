<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['name','model','fuel','price','motor','production_year','picture','concessionaire_id'];

    public function concessionaire() {
    	return $this->belongsTo(Concessionaire::class);
    }
}
