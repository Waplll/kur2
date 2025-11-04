<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'second_name',
        'surname',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'role',
        'avatar_id',
        'role_id',
        'reviews_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class, 'avatar_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'user_id');
    }


    /**
     * Проверка, является ли пользователь администратором
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Получить полное имя пользователя
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->name} {$this->second_name} {$this->surname}");
    }
}
