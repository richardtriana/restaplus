<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone',
        'printer'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_zones');
    }
}
