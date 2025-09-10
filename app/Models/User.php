<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    

  /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // === REPLACE THE OLD $fillable ARRAY WITH THIS ONE ===
    protected $fillable = [
        'name',
        'surname',
        'sa_id_number',
        'mobile_number',
        'email',
        'birth_date',
        'language',
        'is_admin',
        'password' // This is the crucial addition
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The interests that belong to the user.
    */
     public function interests()
    {
    return $this->belongsToMany(Interest::class);
    }

    /**Info change requests */
    public function changeRequests()
{
    return $this->hasMany(UserChangeRequest::class)->latest(); // Order by newest first
}
}
