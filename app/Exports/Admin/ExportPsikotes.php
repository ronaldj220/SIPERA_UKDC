<?php

namespace App\Exports\Admin;
use App\Models\Admin\Psikotes;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportPsikotes implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $psikotes = Psikotes::with(['rekrutmen.user', 'lokasiPsikotes'])->get();
        
        return view('exports.psikotes', ['psikotes' => $psikotes]);
        
    }
}
