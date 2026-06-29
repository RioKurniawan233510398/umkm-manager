<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Finance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::latest()->get();

        $finances = Finance::latest()->get();

        return view(
            'reports.index',
            compact(
                'sales',
                'finances'
            )
        );
    }

    public function pdf()
    {
    $sales = Sale::all();

    $finances = Finance::all();

    $pdf = Pdf::loadView(
        'reports.pdf',
        compact(
            'sales',
            'finances'
        )
    );

    return $pdf->download(
        'laporan-umkm.pdf'
    );
}


}
