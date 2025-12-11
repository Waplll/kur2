<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'application_id'];
    protected $table = 'favorites';

    /**
     * Избранное принадлежит пользователю
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Избранное принадлежит заявке
     */
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
