<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'second_name',
        'surname',
        'email',
        'phone',
        'password_id',
        'avatar_id',
        'reviews_id',
        'role_id',
        'application_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function avatar(){
        return $this->belongsTo(Role::class, 'avatar_id');
    }
    public function reviews() {
        return $this->belongsTo(Reviews::class, 'reviewsid');
    }
    public function application() {
        return $this->belongsTo(Application::class, 'applicationid');
    }
    public function password() {
        return $this->belongsTo(Password::class, 'passwordid');
    }
    public function isAdmin()
    {
        // Предполагаю, что у админа role_id = 1 (или название роли "admin" в таблице role)
        return $this->role_id === 1; // Или: $this->role && $this->role->role === 'admin';
    }
}
