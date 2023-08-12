<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
