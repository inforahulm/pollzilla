<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;


class Group extends Model
{
    protected $table = 'address_group';
    
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'group_owner_id',
        'status',
        'group_join_user_ids',
        'created_at',
        'group_name',
        'group_icon'
    ];

    protected $hidden = [
        'created_at',
        'status',
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getGroupIconAttribute($value)
    {
        return $value ? asset('storage/uploads/group'.'/'.$value) : NULL;
    }
}
