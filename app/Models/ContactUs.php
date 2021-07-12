<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class ContactUs extends Model
{
	protected $table = 'contact_us';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'user_id',
		'subject',
		'message',
		'status',
		'created_at',
		'updated_at'
	];

	protected $hidden = [
		'updated_at',
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}
	public function user_data()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->select('id','user_name');
	}
}
