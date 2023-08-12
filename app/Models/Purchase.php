<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'code'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateCode()
    {
        $this->code = Str::random(10);
        $this->save();
    }

    public function isActive()
    {
        return $this->code !== null;
    }
}
