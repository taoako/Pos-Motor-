<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockInDetails;
use App\Models\StockInTransaction;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Sales Overview
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalSalesToday = Sale::whereDate('date', $today)->sum('total');
        $totalSalesThisWeek = Sale::whereBetween('date', [$startOfWeek, Carbon::now()])->sum('total');
        $totalSalesThisMonth = Sale::whereBetween('date', [$startOfMonth, Carbon::now()])->sum('total');
        $totalSalesAllTime = Sale::sum('total');

        $sales = Sale::with(['product.stockInDetails'])->get();
        $totalTransactions = $sales->unique('transactiondetail_id')->count();
        $totalItemsSold = $sales->sum('quantity');
        $averageTransactionValue = $totalTransactions > 0 ? $sales->sum('total') / $totalTransactions : 0;
        $cogs = $sales->sum(function ($sale) {
            $stockInDetail = $sale->product->stockInDetails->sortByDesc('id')->first();
            $costPrice = $stockInDetail ? $stockInDetail->cost_price : 0;
            return $sale->quantity * $costPrice;
        });
        $grossProfit = $sales->sum('total') - $cogs;

        // Inventory Overview
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<', 10)->get(); // threshold: 10
        $inventoryWorth = Product::sum(DB::raw('stock * (SELECT cost_price FROM stock_in_details WHERE product_id = products.id ORDER BY id DESC LIMIT 1)'));

        // Supplier Overview
        $supplierCount = Supplier::count();
        $recentStockIns = StockInTransaction::with('supplier')->orderByDesc('purchase_date')->take(5)->get();

        return view('partials.dashboard-content', compact(
            'totalSalesToday',
            'totalSalesThisWeek',
            'totalSalesThisMonth',
            'totalSalesAllTime',
            'totalTransactions',
            'totalItemsSold',
            'averageTransactionValue',
            'grossProfit',
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'inventoryWorth',
            'supplierCount',
            'recentStockIns'
        ));
    }
}
