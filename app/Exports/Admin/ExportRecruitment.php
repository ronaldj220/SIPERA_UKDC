<?php

namespace App\Exports\Admin;

use App\Models\Recruitmen;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportRecruitment implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $recruitmen = Recruitmen::with(['lowongan', 'user'])->get();
        return view('exports.rekrutmen', ['recruitmen' => $recruitmen]);
    }
}
