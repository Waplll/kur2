<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model{
    protected $table = 'Application';
    public $timestamps = false;
    protected $fillable = [
        'address',
        'count_rooms',
        'price',
        'path_image',
        'status_id',
        'type_buy_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }
}

