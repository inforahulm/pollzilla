<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;


class AddressBook extends Model
{
	protected $table = 'address_book';
	
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'user_id',
        'contact_user_id',
        'status',
        'created_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'status'
    ];

    // protected $appends = [
    //      'username'   
    // ];

    
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user_details()
    {
        return $this->belongsTo(User::class, 'contact_user_id', 'id')->select('id','user_name','first_name','email','mobile_number','profile_picture');
    }

    // public function getUsernameAttribute()
    // {
    //     return $this->belongsTo(User::class, 'contact_user_id', 'id')->first()->user_name;
    // }
}
