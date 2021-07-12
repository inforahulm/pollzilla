<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;


class ActivityFeed extends Model
{
	protected $table = 'activity_feed';
	
	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'user_id',
		'poll_id',
		'type',
		'created_at'
	];

	protected $hidden = [
		'updated_at'
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function get_feed() 
	{
		return $this->hasOne(Poll::class, 'id', 'poll_id')->select('id','generic_title','poll_style_id');
	}
	public function user_data() {
		return $this->hasOne(User::class, 'id', 'user_id')->select('id','user_name');
	} 
}
