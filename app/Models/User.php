<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Auth;
use DateTimeInterface;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'user_name',
        'email',
        'otp',
        'password',
        'verify_status',
        'first_name',
        'mobile_number',
        'birthdate',
        'gender',
        'profile_picture',
        'country_id',
        'state_id',
        'city_id',
        'company_name',
        'school_name',
        'facebook_url',
        'twitter_url',
        'interest_sub_category_ids',
        'following_user_ids',
        'follower_user_ids',
        'social_types',
        'social_id',
        'device_type',
        'device_token',
        'status',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'current_version',
        'isguest'
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getProfilePictureAttribute($value)
    {
        return $value ? asset('storage/uploads/user').'/'.$value : NULL;
    }

    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCountry() 
    {
        return $this->belongsTo(Country::class,'country_id','id')->select('id','country_name');
    }

    public function getState() 
    {
        return $this->belongsTo(State::class,'state_id','id')->select('id','state_name');
    }

    public function getCity() 
    {
        return $this->belongsTo(City::class,'city_id','id')->select('id','city_name');
    }

    public function poll() 
    {
        return $this->hasMany(Poll::class,'user_id','id');
    }

    public function follower() 
    {
        return $this->hasMany(FollowerFollowing::class,'following_id','id');
    }

    public function following() 
    {
        return $this->hasMany(FollowerFollowing::class,'follower_id','id');
    }

    public function getUserVoted() 
    {
        return $this->hasMany(PollVote::class,'user_id','id');
    }

    public function getUserCreatedPoll() 
    {
        return $this->hasMany(Poll::class,'user_id','id');
    }

}
