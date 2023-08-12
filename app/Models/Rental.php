<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'expiry_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->expiry_date < now();
    }

    public function extendRental($hours)
    {
        $expiry_date = Carbon::create($this->expiry_date);
        $expiryDate = $expiry_date->addHours($hours);
        $this->update(['expiry_date' => $expiryDate]);
    }
}
