<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model{
    protected $table = 'reviews';
    public $timestamps = false;
    protected $fillable = ['reviews'];

    public function Reviews(){
        return $this->hasMany(User::class, 'reviews_id');
    }
}

