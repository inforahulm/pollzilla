<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class InterestCategory extends Model
{
	protected $table = 'interest_category';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'interest_category_name',
		'status',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function subcategories()
	{
		return $this->hasMany(SubInterestCategory::class, 'interest_category_id', 'id');
	}
}
