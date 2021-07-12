<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;

class PollComment extends Model
{
	use HasFactory;

	protected $table = 'poll_comments';

	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'poll_id',
		'comment',
		'user_id',
		'created_at',
		'status'
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
		return $this->hasOne(User::class, 'id', 'user_id')->select('id','user_name','first_name','profile_picture');
	} 
}