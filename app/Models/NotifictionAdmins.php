<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class NotifictionAdmins extends Model
{
	
	protected $table = 'notifiction_admins';
	
	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'id',
		'title',
		'description',
		'sended_at'
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];
}
