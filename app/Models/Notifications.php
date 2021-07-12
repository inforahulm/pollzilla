<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;

class Notifications extends Model
{
	protected $table = 'notification';
	
	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'user_id',
		'notification_type',
		'notification_title',
		'notification_description',
		'status',
		'sender_user_id',
		'poll_id',
		'created_at'
	];

	protected $hidden = [
		'updated_at'
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function user_data() 
	{
		return $this->belongsTo(User::class,'sender_user_id','id')->select('id','user_name','email','mobile_number','first_name','profile_picture');
	}
}
