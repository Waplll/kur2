<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    public $timestamps = false;
    protected $fillable = ['status'];

    public function applications() {
        return $this->hasMany(Application::class, 'status_id');
    }
}


