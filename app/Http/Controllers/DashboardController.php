<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Finance;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Existing data
        $totalProduk = Product::count();
        $totalPenjualan = Sale::sum('jumlah');
        $pendapatan = Finance::where('jenis', 'Pemasukan')->sum('jumlah');
        $stokMenipis = Product::where('stok', '<=', 5)->count();
        $penjualanTerbaru = Sale::with('product')->latest()->first();
        $financeTerbaru = Finance::latest()->first();
        $produkTerbaru = Product::latest()->first();
        $totalPemasukan = Finance::where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = Finance::where('jenis', 'Pengeluaran')->sum('jumlah');
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // Produk terlaris - use leftJoin for SQLite compatibility
        $produkTerlaris = Product::leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(sales.jumlah), 0) as total_terjual'))
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // ========== 1. BUSINESS INSIGHTS ==========
        $insights = [];

        // Previous month sales
        $bulanIni = date('m');
        $bulanLalu = date('m', strtotime('-1 month'));
        $tahunIni = date('Y');
        $tahunLalu = date('Y', strtotime('-1 month'));

        $penjualanBulanIni = Sale::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        $penjualanBulanLalu = Sale::whereMonth('tanggal', $bulanLalu)
            ->whereYear('tanggal', $tahunLalu)
            ->sum('jumlah');

        if ($penjualanBulanIni > 0 || $penjualanBulanLalu > 0) {
            if ($penjualanBulanLalu > 0) {
                $selisihPenjualan = (($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100;
                $arahPenjualan = $selisihPenjualan >= 0 ? 'meningkat' : 'menurun';
                $insights[] = [
                    'icon' => 'fa-chart-line',
                    'text' => "Penjualan {$arahPenjualan} sebesar " . number_format(abs($selisihPenjualan), 1) . "% dibanding bulan lalu.",
                    'type' => $selisihPenjualan >= 0 ? 'positive' : 'negative'
                ];
            } else {
                $insights[] = [
                    'icon' => 'fa-chart-line',
                    'text' => "Total penjualan bulan ini: {$penjualanBulanIni} unit.",
                    'type' => 'positive'
                ];
            }
        }

        // Expense comparison
        $pengeluaranBulanIni = Finance::where('jenis', 'Pengeluaran')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum('jumlah');

        $pengeluaranBulanLalu = Finance::where('jenis', 'Pengeluaran')
            ->whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->sum('jumlah');

        if ($pengeluaranBulanIni > 0 || $pengeluaranBulanLalu > 0) {
            if ($pengeluaranBulanLalu > 0) {
                $selisihPengeluaran = (($pengeluaranBulanIni - $pengeluaranBulanLalu) / $pengeluaranBulanLalu) * 100;
                $arahPengeluaran = $selisihPengeluaran >= 0 ? 'meningkat' : 'menurun';
                $insights[] = [
                    'icon' => 'fa-wallet',
                    'text' => "Pengeluaran {$arahPengeluaran} sebesar " . number_format(abs($selisihPengeluaran), 1) . "% dibanding bulan lalu.",
                    'type' => $selisihPengeluaran >= 0 ? 'negative' : 'positive'
                ];
            } else {
                $insights[] = [
                    'icon' => 'fa-wallet',
                    'text' => "Total pengeluaran bulan ini: Rp " . number_format($pengeluaranBulanIni),
                    'type' => 'neutral'
                ];
            }
        }

        // Best selling category
        $kategoriTerlaris = Sale::select('products.kategori', DB::raw('SUM(sales.jumlah) as total'))
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->whereMonth('sales.tanggal', $bulanIni)
            ->whereYear('sales.tanggal', $tahunIni)
            ->groupBy('products.kategori')
            ->orderByDesc('total')
            ->first();

        if ($kategoriTerlaris && $kategoriTerlaris->total > 0) {
            $insights[] = [
                'icon' => 'fa-star',
                'text' => "Kategori terlaris bulan ini adalah \"{$kategoriTerlaris->kategori}\" dengan {$kategoriTerlaris->total} terjual.",
                'type' => 'positive'
            ];
        }

        // Low stock alert
        if ($stokMenipis > 0) {
            $insights[] = [
                'icon' => 'fa-exclamation-triangle',
                'text' => "Terdapat {$stokMenipis} produk dengan stok menipis.",
                'type' => 'negative'
            ];
        }

        // Revenue comparison
        $pendapatanBulanIni = Finance::where('jenis', 'Pemasukan')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum('jumlah');

        $pendapatanBulanLalu = Finance::where('jenis', 'Pemasukan')
            ->whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->sum('jumlah');

        if ($pendapatanBulanIni > 0 || $pendapatanBulanLalu > 0) {
            if ($pendapatanBulanLalu > 0) {
                $selisihPendapatan = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
                $arahPendapatan = $selisihPendapatan >= 0 ? 'meningkat' : 'menurun';
                $insights[] = [
                    'icon' => 'fa-money-bill-trend-up',
                    'text' => "Pendapatan {$arahPendapatan} sebesar " . number_format(abs($selisihPendapatan), 1) . "% dibanding bulan lalu.",
                    'type' => $selisihPendapatan >= 0 ? 'positive' : 'negative'
                ];
            }
        }

        if (empty($insights)) {
            $insights[] = [
                'icon' => 'fa-info-circle',
                'text' => 'Data belum mencukupi untuk analisis.',
                'type' => 'neutral'
            ];
        }

        // ========== 2. BUSINESS HEALTH SCORE ==========
        // Profit growth (40%)
        $profitBulanIni = $pendapatanBulanIni - $pengeluaranBulanIni;
        $profitBulanLalu = $pendapatanBulanLalu - $pengeluaranBulanLalu;
        $skorProfit = 0;
        if ($profitBulanLalu > 0) {
            $pertumbuhanProfit = (($profitBulanIni - $profitBulanLalu) / $profitBulanLalu) * 100;
            $skorProfit = min(100, max(0, ($pertumbuhanProfit + 100) / 2));
        } elseif ($profitBulanIni > 0) {
            $skorProfit = 70;
        }

        // Sales growth (30%)
        $skorPenjualan = 0;
        if ($penjualanBulanLalu > 0) {
            $pertumbuhanPenjualan = (($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100;
            $skorPenjualan = min(100, max(0, ($pertumbuhanPenjualan + 100) / 2));
        } elseif ($penjualanBulanIni > 0) {
            $skorPenjualan = 70;
        }

        // Stock availability (20%)
        $totalStok = Product::sum('stok');
        $totalProductCount = Product::count();
        $skorStok = 0;
        if ($totalProductCount > 0) {
            $rataStok = $totalStok / $totalProductCount;
            $skorStok = min(100, ($rataStok / 50) * 100);
            if ($stokMenipis > 0) {
                $skorStok = max(0, $skorStok - ($stokMenipis * 10));
            }
        }

        // Expense efficiency (10%)
        $skorBiaya = 50;
        if ($pendapatanBulanIni > 0) {
            $rasioBiaya = $pengeluaranBulanIni / $pendapatanBulanIni;
            $skorBiaya = max(0, min(100, (1 - $rasioBiaya) * 100));
        }

        $healthScore = ($skorProfit * 0.4) + ($skorPenjualan * 0.3) + ($skorStok * 0.2) + ($skorBiaya * 0.1);
        $healthScore = round($healthScore);

        if ($healthScore <= 40) {
            $healthCategory = 'Poor';
            $healthRecommendation = 'Kinerja penjualan rendah. Tingkatkan promosi dan strategi pemasaran.';
            $healthColor = 'danger';
        } elseif ($healthScore <= 60) {
            $healthCategory = 'Fair';
            $healthRecommendation = 'Kinerja perlu ditingkatkan. Optimalkan biaya operasional.';
            $healthColor = 'warning';
        } elseif ($healthScore <= 80) {
            $healthCategory = 'Good';
            $healthRecommendation = 'Kinerja bisnis stabil. Pertahankan dan tingkatkan terus.';
            $healthColor = 'info';
        } else {
            $healthCategory = 'Excellent';
            $healthRecommendation = 'Bisnis Anda berkembang sangat baik. Terus berinovasi!';
            $healthColor = 'success';
        }

        // ========== 3. PRODUCT PRICE SUGGESTIONS ==========
        $productSuggestions = Product::leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(sales.jumlah), 0) as total_terjual'))
            ->groupBy('products.id')
            ->get()
            ->map(function ($product) {
                $saran = [];
                if ($product->production_cost && $product->production_cost > 0) {
                    $hargaSaran = $product->production_cost * 1.3;
                    $saran['harga_saran'] = round($hargaSaran);
                    $saran['margin'] = 30;

                    $terjual = $product->total_terjual ?? 0;
                    if ($product->stok <= 5 && $terjual > 0) {
                        $saran['harga_saran'] = round($hargaSaran * 1.1);
                        $saran['rekomendasi'] = 'Tingkatkan harga sebesar 10%.';
                        $saran['alasan'] = 'Stok menipis dan permintaan tinggi.';
                    } elseif ($product->stok > 20 && $terjual == 0) {
                        $saran['rekomendasi'] = 'Berikan diskon promosi.';
                        $saran['alasan'] = 'Stok tinggi dan belum ada penjualan.';
                    } else {
                        $saran['rekomendasi'] = 'Harga sesuai margin 30%.';
                        $saran['alasan'] = 'Harga jual sudah ideal.';
                    }
                } else {
                    $saran['harga_saran'] = null;
                    $saran['rekomendasi'] = 'Biaya produksi belum diisi.';
                    $saran['alasan'] = 'Isi production_cost untuk saran harga.';
                }
                $saran['product'] = $product;
                return $saran;
            });

        // ========== 4. PRODUCT ANALYSIS (SQLite compatible) ==========
        // A. Best-selling products - Top 5 by quantity sold
        $bestSellers = Product::leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(sales.jumlah), 0) as total_terjual'))
            ->groupBy('products.id')
            ->having(DB::raw('COALESCE(SUM(sales.jumlah), 0)'), '>', 0)
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // B. Most profitable products - Top 5 by revenue
        $mostProfitable = Sale::select('product_id', DB::raw('SUM(total_harga) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->with('product')
            ->get();

        // C. Slow-moving products - rarely sold (1-2 units)
        $slowMoving = Product::leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(sales.jumlah), 0) as total_terjual'))
            ->groupBy('products.id')
            ->having(DB::raw('COALESCE(SUM(sales.jumlah), 0)'), '>', 0)
            ->having(DB::raw('COALESCE(SUM(sales.jumlah), 0)'), '<=', 2)
            ->orderBy('total_terjual')
            ->take(5)
            ->get();

        // D. Unsold products - never sold
        $unsoldProducts = Product::whereDoesntHave('sales')->get();

        // ========== 5. SALES CHART DATA (real data from database) ==========
        $filter = request('filter', 'all');

        $chartQuery = Sale::selectRaw("DATE(created_at) as date, SUM(total_harga) as total, SUM(jumlah) as quantity")
            ->groupBy('date')
            ->orderBy('date');

        switch ($filter) {
            case 'today':
                $chartQuery->whereDate('created_at', now());
                break;
            case '7days':
                $chartQuery->whereDate('created_at', '>=', now()->subDays(7));
                break;
            case '30days':
                $chartQuery->whereDate('created_at', '>=', now()->subDays(30));
                break;
            case 'month':
                $chartQuery->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'all':
            default:
                break;
        }

        $chartData = $chartQuery->get();

        $chartLabels = $chartData->pluck('date')->map(function($d) {
            return \Carbon\Carbon::parse($d)->format('d M');
        });
        $chartValues = $chartData->pluck('total');
        $chartQuantities = $chartData->pluck('quantity');
        $chartFilter = $filter;

        // ========== 6. UPCOMING ACTIVITIES ==========
        $upcomingActivities = Activity::where('status', 'pending')
            ->whereDate('activity_date', '>=', now())
            ->orderBy('activity_date')
            ->take(5)
            ->get();

        $todayActivities = Activity::whereDate('activity_date', now())->get();

        return view(
            'dashboard.index',
            compact(
                'totalProduk',
                'totalPenjualan',
                'pendapatan',
                'stokMenipis',
                'produkTerbaru',
                'penjualanTerbaru',
                'financeTerbaru',
                'totalPemasukan',
                'totalPengeluaran',
                'labaBersih',
                'produkTerlaris',
                'insights',
                'healthScore',
                'healthCategory',
                'healthRecommendation',
                'healthColor',
                'productSuggestions',
                'bestSellers',
                'mostProfitable',
                'slowMoving',
                'unsoldProducts',
                'chartLabels',
                'chartValues',
                'chartQuantities',
                'chartFilter',
                'upcomingActivities',
                'todayActivities'
            )
        );
    }
}
