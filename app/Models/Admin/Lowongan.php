<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Lowongan extends Model
{
    use HasFactory;
    use Sortable;
    public $timestamps = false;
    protected $table = 'lowongan';
    protected $fillable = [
        'img_base_64',
        'link_lowongan',
        'name_lowongan',
        'lokasi_lowongan',
        'description',
        'created_at',
        'expired_at'
    ];
    
    // Relasi satu ke banyak dengan Recruitmen
    public function recruitmen()
    {
        return $this->hasMany(Recruitmen::class);
    }
    
    public $sortable = [
        'name_lowongan',
        'created_at',
        'expired_at'
    ];
}
