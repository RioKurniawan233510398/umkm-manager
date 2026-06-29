<h2>Laporan UMKM</h2>

<h4>Penjualan</h4>

<table border="1" width="100%">

<tr>
<th>No</th>
<th>Produk</th>
<th>Total</th>
</tr>

@foreach($sales as $sale)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $sale->product->nama_produk }}</td>

<td>
Rp {{ number_format($sale->total_harga) }}
</td>

</tr>

@endforeach

</table>

<br>

<h4>Keuangan</h4>

<table border="1" width="100%">

<tr>

<th>No</th>
<th>Jenis</th>
<th>Jumlah</th>

</tr>

@foreach($finances as $finance)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $finance->jenis }}</td>

<td>
Rp {{ number_format($finance->jumlah) }}
</td>

</tr>

@endforeach

</table>
