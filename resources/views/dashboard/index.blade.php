@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>

    .stat-card{
        border:none;
        border-radius:25px;
        color:white;
        padding:30px;
        transition:0.3s;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
    }

    .stat-card:hover{
        transform:translateY(-8px);
    }

    .bg-blue{
        background:linear-gradient(135deg,#0F2D7A,#2563EB);
    }

    .bg-green{
        background:linear-gradient(135deg,#16A34A,#22C55E);
    }

    .bg-orange{
        background:linear-gradient(135deg,#F59E0B,#FBBF24);
    }

    .bg-purple{
        background:linear-gradient(135deg,#7C3AED,#A855F7);
    }

    .dashboard-card{
        background:white;
        border:none;
        border-radius:25px;
        padding:25px;
        box-shadow:0 5px 15px rgba(0,0,0,.08);
        margin-top:30px;
    }

    .activity-item{
        padding:15px 0;
        border-bottom:1px solid #eee;
    }

    .activity-item:last-child{
        border-bottom:none;
    }

    .insight-card{
        border:none;
        border-radius:20px;
        padding:20px;
        margin-bottom:15px;
        box-shadow:0 3px 10px rgba(0,0,0,.05);
    }

    .health-progress{
        height:20px;
        border-radius:10px;
    }

</style>

<!-- Stat Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-blue">
            <h6>Total Produk</h6>
            <h2>{{ $totalProduk }}</h2>
            <i class="fas fa-box fa-3x mt-3"></i>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-green">
            <h6>Total Penjualan</h6>
            <h2>{{ $totalPenjualan }}</h2>
            <i class="fas fa-shopping-cart fa-3x mt-3"></i>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-orange">
            <h6>Pendapatan</h6>
            <h2>Rp {{ number_format($pendapatan,0,',','.') }}</h2>
            <i class="fas fa-wallet fa-3x mt-3"></i>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-purple">
            <h6>Stok Menipis</h6>
            <h2>{{ $stokMenipis }}</h2>
            <i class="fas fa-exclamation-triangle fa-3x mt-3"></i>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik -->
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Grafik Penjualan</h4>
                <div class="btn-group btn-group-sm">
                    <a href="?filter=today" class="btn btn-outline-primary {{ $chartFilter == 'today' ? 'active' : '' }}">Today</a>
                    <a href="?filter=7days" class="btn btn-outline-primary {{ $chartFilter == '7days' ? 'active' : '' }}">Last 7 Days</a>
                    <a href="?filter=30days" class="btn btn-outline-primary {{ $chartFilter == '30days' ? 'active' : '' }}">Last 30 Days</a>
                    <a href="?filter=month" class="btn btn-outline-primary {{ $chartFilter == 'month' ? 'active' : '' }}">This Month</a>
                    <a href="?filter=all" class="btn btn-outline-primary {{ $chartFilter == 'all' ? 'active' : '' }}">All Time</a>
                </div>
            </div>
            @if($chartLabels && $chartLabels->count() > 0)
            <canvas id="salesChart"></canvas>
            @else
            <div class="text-center py-5 text-muted" id="noSalesData">
                <i class="fas fa-chart-bar fa-3x mb-3"></i>
                <p>No sales data available</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-4">
        <div class="dashboard-card">
            <h4 class="mb-4">Aktivitas Terbaru</h4>

            @if($produkTerbaru)
            <div class="activity-item">
                📦 Produk terbaru: {{ $produkTerbaru->nama_produk }}
            </div>
            @else
            <div class="activity-item">📦 Belum ada produk</div>
            @endif

            @if($penjualanTerbaru && $penjualanTerbaru->product)
            <div class="activity-item">
                🛒 Penjualan terbaru: {{ $penjualanTerbaru->product->nama_produk }} ({{ $penjualanTerbaru->jumlah }})
            </div>
            @else
            <div class="activity-item">🛒 Belum ada penjualan</div>
            @endif

            @if($financeTerbaru)
            <div class="activity-item">
                💰 Keuangan terbaru: {{ $financeTerbaru->jenis }} Rp {{ number_format($financeTerbaru->jumlah) }}
            </div>
            @else
            <div class="activity-item">💰 Belum ada data keuangan</div>
            @endif
        </div>
    </div>
</div>

<!-- ========== 1. BUSINESS INSIGHTS ========== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-lightbulb text-warning"></i> Business Insights</h4>
            <div class="row">
                @forelse($insights as $insight)
                <div class="col-md-6 mb-3">
                    <div class="insight-card" style="border-left: 5px solid {{ $insight['type'] == 'positive' ? '#16A34A' : ($insight['type'] == 'negative' ? '#DC3545' : '#FFC107') }};">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas {{ $insight['icon'] }} fa-2x" style="color: {{ $insight['type'] == 'positive' ? '#16A34A' : ($insight['type'] == 'negative' ? '#DC3545' : '#FFC107') }};"></i>
                            <div>
                                <p class="mb-0">{{ $insight['text'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">Data belum mencukupi untuk analisis.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ========== 2. BUSINESS HEALTH SCORE ========== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-heartbeat text-danger"></i> Business Health Score</h4>
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <h1 class="display-4 fw-bold text-{{ $healthColor }}">{{ $healthScore }}/100</h1>
                    <h5 class="text-{{ $healthColor }}">{{ $healthCategory }}</h5>
                </div>
                <div class="col-md-8">
                    <div class="progress health-progress mb-3">
                        <div class="progress-bar bg-{{ $healthColor }}" role="progressbar" style="width: {{ $healthScore }}%"></div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-3">
                            <small>Profit Growth</small>
                            <div class="fw-bold">40%</div>
                        </div>
                        <div class="col-3">
                            <small>Sales Growth</small>
                            <div class="fw-bold">30%</div>
                        </div>
                        <div class="col-3">
                            <small>Stock Avail.</small>
                            <div class="fw-bold">20%</div>
                        </div>
                        <div class="col-3">
                            <small>Expense Eff.</small>
                            <div class="fw-bold">10%</div>
                        </div>
                    </div>
                    <div class="alert alert-{{ $healthColor }} mt-3 mb-0">
                        <i class="fas fa-info-circle"></i> {{ $healthRecommendation }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== 3. PRODUCT PRICE SUGGESTIONS ========== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-tags text-success"></i> Product Price Suggestions</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Jual</th>
                            <th>Biaya Produksi</th>
                            <th>Harga Saran</th>
                            <th>Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productSuggestions as $saran)
                        <tr>
                            <td>{{ $saran['product']->nama_produk }}</td>
                            <td>Rp {{ number_format($saran['product']->harga) }}</td>
                            <td>Rp {{ number_format($saran['product']->production_cost ?? 0) }}</td>
                            <td>
                                @if($saran['harga_saran'])
                                    Rp {{ number_format($saran['harga_saran']) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $saran['rekomendasi'] }}</small><br>
                                <small class="text-info">{{ $saran['alasan'] }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Belum ada data produk</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ========== 4. PRODUCT ANALYSIS ========== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-chart-pie text-primary"></i> Product Analysis</h4>
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-success">🏆 Best-Selling Products</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Produk</th><th>Terjual</th></tr></thead>
                        <tbody>
                            @forelse($bestSellers as $p)
                            <tr><td>{{ $p->nama_produk }}</td><td>{{ $p->total_terjual ?? 0 }}</td></tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">Belum ada penjualan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-warning">💰 Most Profitable Products</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Produk</th><th>Revenue</th></tr></thead>
                        <tbody>
                            @forelse($mostProfitable as $p)
                            <tr>
                                <td>{{ $p->product->nama_produk ?? '-' }}</td>
                                <td>Rp {{ number_format($p->total_revenue) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 mt-3">
                    <h5 class="text-danger">🐢 Slow-Moving Products</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Produk</th><th>Terjual</th></tr></thead>
                        <tbody>
                            @forelse($slowMoving as $p)
                            <tr><td>{{ $p->nama_produk }}</td><td>{{ $p->total_terjual ?? 0 }}</td></tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">Tidak ada produk lambat</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 mt-3">
                    <h5 class="text-secondary">📦 Unsold Products</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Produk</th><th>Stok</th></tr></thead>
                        <tbody>
                            @forelse($unsoldProducts as $p)
                            <tr><td>{{ $p->nama_produk }}</td><td>{{ $p->stok }}</td></tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">Semua produk terjual</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== 5. UPCOMING ACTIVITIES ========== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-calendar-alt text-primary"></i> Upcoming Activities</h4>
            <div class="row">
                @forelse($upcomingActivities as $activity)
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <h6>{{ $activity->title }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}
                        </small>
                        <br>
                        @if($activity->status == 'pending')
                            <span class="badge bg-warning text-dark mt-2">Pending</span>
                        @else
                            <span class="badge bg-success mt-2">Selesai</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">Tidak ada aktivitas mendatang.</p>
                </div>
                @endforelse
            </div>
            @if($todayActivities->count() > 0)
            <div class="alert alert-info mt-3">
                <i class="fas fa-bell"></i> {{ $todayActivities->count() }} aktivitas hari ini!
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Produk Terlaris & Ringkasan Keuangan -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="dashboard-card">
            <h4 class="mb-4">Produk Terlaris</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @if($produkTerlaris && $produkTerlaris->count() > 0)
                @foreach($produkTerlaris as $produk)
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->total_terjual ?? 0 }}</td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="2" class="text-center">Belum ada penjualan</td>
                    </tr>
            @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-card">
            <h4 class="mb-4">Ringkasan Keuangan</h4>
            <p><strong>Pemasukan :</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            <p><strong>Pengeluaran :</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            <p><strong>Laba Bersih :</strong> Rp {{ number_format($labaBersih, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if($chartLabels && $chartLabels->count() > 0)
<script>
const ctx = document.getElementById('salesChart');
let salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($chartValues),
            backgroundColor: '#0F2D7A',
            borderRadius: 8
        }]
    },
    options: {
        responsive:true,
        plugins:{ legend:{ display:true, position:'top' } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Auto-refresh chart when page becomes visible (e.g., after returning from sale operations)
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        // Check if there's a success message indicating a sale was just made
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || '{{ $chartFilter }}';

        // Reload the page to get fresh data
        if (sessionStorage.getItem('saleUpdated') === 'true') {
            sessionStorage.removeItem('saleUpdated');
            window.location.href = window.location.pathname + '?filter=' + filter;
        }
    }
});

// Listen for sale success messages and trigger refresh
@if(session('success'))
    sessionStorage.setItem('saleUpdated', 'true');
@endif
</script>
@endif

@endsection
