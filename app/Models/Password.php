<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Password extends Model
{
    use HasFactory;

    protected $table = 'password';
    protected $fillable = ['new_password', 'old_password'];
    protected $hidden = ['new_password', 'old_password'];

    public function user() {
        return $this->hasOne(User::class, 'passwordid');
    }

    // Методы-хелперы для паролей, например:
    // set, verify, update, проверка возраста — добавляй под свои нужды
}
