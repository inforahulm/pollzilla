<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class PollAnswer extends Model
{
	protected $table = 'poll_answer';
	
	use HasFactory;
	protected $fillable = [
		'id',
		'poll_id',
		'poll_text_answer',
		'poll_source_answer',
		'is_link',
		'video_thumb',
		'media_type',
		'answer_index'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	protected  $appends = [
		'answer_count'
	];


	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}
	
	public function getPollSourceAnswerAttribute($value) 
	{
		if($value){
			if(strpos($value, 'http') === 0) 
				return $value;
			else
				return $value ? asset('storage/uploads/poll/').'/'.$value : NULL;
		}
	}

	public function getVideoThumbAttribute($value) 
	{
		if($value){
			if(strpos($value, 'http') === 0) 
				return $value;
			else
				return $value ? asset('storage/uploads/poll/').'/'.$value : NULL;
		}
	}

	public function vote_answer() 
	{
		return $this->hasMany(PollVote::class, 'poll_answer_id', 'id');	
	}

	public function getAnswerCountAttribute() 
	{
		return $this->hasMany(PollVote::class, 'poll_answer_id', 'id')->count();
	}

}
