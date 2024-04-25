<?php

namespace App\Models;

use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_Has_User extends Model
{
    use HasFactory;
    protected $table = 'role_has_users';
    protected $fillable = [
        'fk_user',
        'fk_role'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'fk_role');
    }
}
