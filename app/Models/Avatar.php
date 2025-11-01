<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model{
    protected $table = 'avatar';
    public $timestamps = false;
    protected $fillable = ['avatar'];

    public function Avatar(){
        return $this->hasMany(User::class, 'avatar_id');
    }
}

