<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class StatusPegawai extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'status_pegawai';
    
    protected $fillable = [
        'nama_status',    
    ];
    
    public $sortable = ['nama_status'];
}
