<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'state_name',
		'status'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
