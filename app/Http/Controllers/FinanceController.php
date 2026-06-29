<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $finances = Finance::latest()->paginate(10);

    $totalPemasukan = Finance::where(
        'jenis',
        'Pemasukan'
    )->sum('jumlah');

    $totalPengeluaran = Finance::where(
        'jenis',
        'Pengeluaran'
    )->sum('jumlah');

    $labaBersih =
        $totalPemasukan - $totalPengeluaran;

    return view(
        'finance.index',
        compact(
            'finances',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih'
        )
    );
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    return view('finance.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
