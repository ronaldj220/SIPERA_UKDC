<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin\StatusPegawai;

class UniqueStatusPegawai implements Rule
{
    private $inputValue;
    
    public function __construct($inputValue){
        $this->inputValue = $inputValue;
    }
    
    public function passes($attribute, $value){
        // Check if status_pegawai already exists
        return !StatusPegawai::where('nama_status', $this->inputValue)->exists();
    }
    
    public function message()
    {
        return "Status pegawai '{$this->inputValue}' sudah ada, silakan masukkan yang lain.";
    }
}
