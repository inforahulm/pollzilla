<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCategories extends Model
{
	protected $table = 'report_categories';
	use HasFactory;

	protected $fillable = [
		'id',
		'name',
		'parent_id',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
