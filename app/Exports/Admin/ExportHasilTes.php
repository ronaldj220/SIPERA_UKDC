<?php

namespace App\Exports\Admin;
use App\Models\Admin\Surat_Penerimaan;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class ExportHasilTes implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $suratPenerimaan = Surat_Penerimaan::with('departemen')->get();
        
        return view('exports.hasil_tes', ['hasil_tes', $suratPenerimaan]);
    }
}
