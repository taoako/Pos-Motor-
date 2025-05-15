<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function getSalesData(Request $request)
    {
        $period = $request->input('period', 'daily'); // default to daily
        $format = 'Y-m-d';

        switch ($period) {
            case 'weekly':
                $format = 'o-\WW'; // ISO-8601 week number
                break;
            case 'monthly':
                $format = 'Y-m';
                break;
        }

        $sales = Sale::select(
            DB::raw("DATE_FORMAT(date, '{$format}') as period"),
            DB::raw('SUM(total) as total_sales')
        )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json($sales);
    }

    public function index(Request $request)
    {
        // Top-Selling Products
        $topSellingProducts = Sale::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->with('product')
            ->get();

        // Recent Orders
        $recentOrders = Sale::with(['transactionDetail.transaction.customer', 'product'])
            ->orderByDesc('date')
            ->take(10)
            ->get();

        // Sales Chart Data (Group by Date)
        $dailySales = Sale::select(DB::raw('DATE(date) as day'), DB::raw('SUM(total) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $weeklySales = Sale::select(DB::raw('YEARWEEK(date, 1) as week'), DB::raw('SUM(total) as total'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $monthlySales = Sale::select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Sales Summary Report
        $sales = Sale::with('product')->get();

        // Calculate Total Sales
        $totalSales = $sales->sum('total');

        // Calculate Total Transactions
        $totalTransactions = $sales->unique('transactiondetail_id')->count();

        // Calculate Total Items Sold
        $totalItemsSold = $sales->sum('quantity');

        // Calculate Average Transaction Value
        $averageTransactionValue = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        // Calculate Gross Profit using StockInDetails cost_price
        $cogs = $sales->sum(function ($sale) {
            // Get latest stock-in detail for the product
            $stockInDetail = $sale->product->stockInDetails->sortByDesc('id')->first();
            $costPrice = $stockInDetail ? $stockInDetail->cost_price : 0;
            return $sale->quantity * $costPrice;
        });
        $grossProfit = $totalSales - $cogs;


        return view('partials.sales-content', compact(
            'topSellingProducts',
            'recentOrders',
            'dailySales',
            'weeklySales',
            'monthlySales',
            'totalSales',
            'totalTransactions',
            'totalItemsSold',
            'averageTransactionValue',
            'grossProfit'
        ));
    }
}
