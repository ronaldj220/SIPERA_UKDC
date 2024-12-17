<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\Role;
use App\Models\Admin\Agama;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'NIP',
        'gender',
        'alamat',
        'tempat_lahir',
        'tgl_lahir',
        'id_agama',
        'phone_number',
        'universitas',
        'pendidikan',
        'jurusan',
        'password',
        'is_active'
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
        'password' => 'hashed',
    ];
    public function role_has_user()
    {
        return $this->hasMany(Role_Has_User::class, 'fk_user', 'id');
    }
    public function agama()
    {
        return $this->belongsTo(Agama::class, 'id_agama');
    }
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class, 'id_users');
    }
    
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_users', 'fk_user', 'fk_role');
    }
}
