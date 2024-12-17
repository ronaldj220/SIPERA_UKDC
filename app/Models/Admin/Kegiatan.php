<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Kegiatan extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'master_kegiatan';
    
    protected $fillable = [
        'kegiatan'
    ];
    public $sortable = [
        'kegiatan'
    ];
}
