<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'is_active',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/Category'.'/'.$value) : NULL;
    }
}
