<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'phone',
        'address',
        'price',
        'type_buy_id',
        'status_id',
        'count_rooms',
        'path_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function typeBuy()
    {
        return $this->belongsTo(TypeBuy::class, 'type_buy_id');
    }

    /**
     * Пользователи, добавившие это в избранное
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'application_id', 'user_id')->withTimestamps();
    }

    /**
     * Проверить добавлена ли в избранное текущим пользователем
     */
    public function isFavoritedBy($userId)
    {
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }
}
