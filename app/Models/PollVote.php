<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;


class PollVote extends Model
{
	use HasFactory;

	protected $table = 'poll_voting';

	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'poll_id',
		'poll_answer_id',
		'user_id',
		'other_answer'
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function getPollDetails() 
	{
		return $this->belongsTo(Poll::class, 'poll_id', 'id')->select('id','poll_style_id','generic_title');
	}

	public function getPollVoter() 
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->select('id','user_name','birthdate');
	}
	public function getPollCreator() 
	{
		return $this->belongsTo(Poll::class, 'poll_id', 'id');
	}

	public function getPollAnswer() 
	{
		return $this->belongsTo(PollAnswer::class, 'poll_answer_id', 'id');
	}
}
