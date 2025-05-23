<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'box_id',
        'user_id'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
