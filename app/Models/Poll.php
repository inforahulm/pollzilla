<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Poll extends Model
{
	use HasFactory;

	protected $table ='create_poll';

	protected $fillable = [
		'id',
		'interest_category_id',
		'interest_sub_category_id',
		'generic_title',
		'poll_type_id',
		'no_of_option',
		'color_palette_id',
		'is_light',
		'poll_style_id',
		'background',
		'is_background_image',
		'template_id',
		'launch_date_time',
		'forever_status',
		'set_duration',
		'poll_privacy',
		'chart_id',
		'share_status',
		'user_id',
		'status',
		'is_secret',
		'poll_current_status',
		'poll_preview',
		'poll_time',
		'is_theme',
		'other_contact_invite_count',
		'created_at'
	];

	protected $hidden = [
		'updated_at',
	];

	protected  $appends = [
		'current_time'
	];

	public function getCurrentTimeAttribute() 
	{
		return date('Y-m-d H:i:s');
	}

	public function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function categories()
	{
		return $this->belongsTo(InterestCategory::class, 'interest_category_id', 'id');
	}

	public function subcategories()
	{
		return $this->belongsTo(SubInterestCategory::class, 'interest_sub_category_id', 'id');
	}

	public function poll_answer() 
	{
		return $this->hasMany(PollAnswer::class, 'poll_id', 'id');	
	}
	public function getBackgroundAttribute($value) 
	{
		if($value)
			return $value ? asset('storage/uploads/poll').'/'.$value : NULL;
	}

	public function getPollPreviewAttribute($value) 
	{
		if($value)
			return $value ? asset('storage/uploads/poll').'/'.$value : NULL;
	}

	public function pollVotting() 
	{
		return $this->hasMany(PollVote::class,'poll_id','id');
	}
	public function pollInvite() 
	{
		return $this->hasMany(PollInvite::class,'poll_id','id');
	}

	public function pollComment() 
	{
		return $this->hasMany(PollComment::class,'poll_id','id');
	}

	public function get_feed() 
	{
		return $this->hasMany(ActivityFeed::class, 'poll_id', 'id');
	}

	public function getRandomPoll() 
	{
		// dd($this->id);
		// 
		return $this->hasMany(PollVote::class);
	}
	public function pollCreatorUser() 
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	public function user_data() {
		return $this->hasOne(User::class, 'id', 'user_id')->select('id','user_name','first_name','email','mobile_number','profile_picture');
	}
	public function color_palette_data() {
		return $this->hasOne(ColorPalette::class, 'id', 'color_palette_id')->select('id','components_code','background_code','color_palette_name');
	}
}