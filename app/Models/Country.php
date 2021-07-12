<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'country';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'country_name',
		'status'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
