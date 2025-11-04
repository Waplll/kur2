<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeBuy extends Model
{
    protected $table = 'type_buy';
    protected $fillable = ['type_buy'];

    public function applications()
    {
        return $this->hasMany(Application::class, 'type_buy_id');
    }
}
