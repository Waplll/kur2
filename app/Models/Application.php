<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $fillable = [
        'address',
        'count_rooms',
        'price',
        'path_image',
        'type_buy_id',
        'status_id',
        'user_id',
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
}
