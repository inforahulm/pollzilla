<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class ColorPalette extends Model
{
	protected $table = 'color_palette';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'components_code',
		'background_code',
		'color_palette_name',
		'status'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

}
