<?php

namespace App\Models\Admin;

use App\Models\Role_Has_User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $fillable = ['role'];
    public function role_has_user()
    {
        return $this->hasOne(Role_Has_User::class, 'fk_role');
    }
}
