<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InterestCategory;
use DateTimeInterface;


class SubInterestCategory extends Model
{
	protected $table = 'interest_sub_category';

	use HasFactory;
	
	protected $fillable = [
		'id',
		'interest_category_id',
		'interest_sub_category_name',
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
	public function categories()
	{
		return $this->belongsTo(InterestCategory::class, 'interest_category_id', 'id');
	}
}
