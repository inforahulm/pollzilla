<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;

class PollInvite extends Model
{
	use HasFactory;

	protected $table = 'poll_invites';

	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'poll_owner_id',
		'group_or_user_id',
		'poll_id',
		'is_group'
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
		return $this->hasOne(User::class, 'id', 'group_or_user_id')->select('id','user_name','first_name','profile_picture');
	} 
}
