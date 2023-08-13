<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount','price','is_rentable','status'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
