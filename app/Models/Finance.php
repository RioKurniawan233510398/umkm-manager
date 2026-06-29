<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [

        'jenis',
        'keterangan',
        'jumlah',
        'tanggal'

    ];

    public function index()
    {
    $finances = Finance::latest()
                    ->paginate(10);

    $totalPemasukan =
        Finance::where(
            'jenis',
            'Pemasukan'
        )->sum('jumlah');

    $totalPengeluaran =
        Finance::where(
            'jenis',
            'Pengeluaran'
        )->sum('jumlah');

    $labaBersih =
        $totalPemasukan -
        $totalPengeluaran;

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

public function create()
{
    return view('finance.create');
}

public function store(Request $request)
{
    $request->validate([

        'jenis' => 'required',
        'keterangan' => 'required',
        'jumlah' => 'required|numeric',
        'tanggal' => 'required'

    ]);

    Finance::create($request->all());

    return redirect('/finance')
            ->with(
                'success',
                'Data keuangan berhasil ditambahkan'
            );
}

}

