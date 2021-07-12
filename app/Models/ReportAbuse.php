<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAbuse extends Model
{
	protected $table = 'report_abuse';
	use HasFactory;

	protected $fillable = [
		'id',
		'poll_id',
		'user_id',
		'report_categories_id',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
