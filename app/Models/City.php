<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'city_name',
		'status'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
