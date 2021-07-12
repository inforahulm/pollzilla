<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Auth;
use Route;
use DateTimeInterface;

class FollowerFollowing extends Model
{
    protected $table = 'follower_following';
    
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'follower_id',
        'following_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'is_following'
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    public function user_details()
    {
        return $this->hasOne(User::class, 'id', 'follower_id')->select('id','user_name','email','mobile_number','first_name','profile_picture');
    }

    public function userDetails()
    {
        return $this->hasOne(User::class, 'id', 'following_id')->select('id','user_name','email','mobile_number','first_name','profile_picture');
    }

    public function getIsFollowingAttribute()
    {
        if(Route::current()->uri == "api/following-list")
        {
            $is_exists =  FollowerFollowing::where('follower_id',Auth::user()->id)->where('following_id',$this->following_id)->exists();
        }
        else
        {
            $is_exists =  FollowerFollowing::where('follower_id',Auth::user()->id)->where('following_id',$this->follower_id)->exists();
        }


        return $is_exists ? 1 :0;
    }
}
