<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesUserBranch;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ResolvesUserBranch;

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            return view('dashboard', array_merge(
                $this->ownerMetrics(),
                ['charts' => $this->buildCharts($user, null)]
            ));
        }

        if (!$user->branch_id) {
            return view('dashboard', [
                'totalProducts' => 0,
                'totalTransactions' => 0,
                'totalIncome' => 0,
                'totalStock' => 0,
                'lowStocks' => collect(),
                'latestTransactions' => collect(),
                'charts' => $this->emptyCharts(),
                'branchWarning' => true,
            ]);
        }

        $branchId = $user->branch_id;

        return view('dashboard', array_merge(
            $this->branchMetrics($branchId),
            ['charts' => $this->buildCharts($user, $branchId)]
        ));
    }

    private function ownerMetrics(): array
    {
        return [
            'totalBranches' => Branch::count(),
            'totalProducts' => Product::count(),
            'totalTransactions' => Transaction::count(),
            'totalIncome' => Transaction::sum('total_price'),
            'totalStock' => Stock::sum('quantity'),
            'lowStocks' => Stock::with(['branch', 'product'])
                ->where('quantity', '<=', 10)
                ->orderBy('quantity')
                ->limit(5)
                ->get(),
            'latestTransactions' => Transaction::with(['branch', 'cashier'])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    private function branchMetrics(int $branchId): array
    {
        return [
            'totalProducts' => Product::count(),
            'totalTransactions' => Transaction::where('branch_id', $branchId)->count(),
            'totalIncome' => Transaction::where('branch_id', $branchId)->sum('total_price'),
            'totalStock' => Stock::where('branch_id', $branchId)->sum('quantity'),
            'lowStocks' => Stock::with(['branch', 'product'])
                ->where('branch_id', $branchId)
                ->where('quantity', '<=', 10)
                ->orderBy('quantity')
                ->limit(5)
                ->get(),
            'latestTransactions' => Transaction::with(['branch', 'cashier'])
                ->where('branch_id', $branchId)
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    private function emptyCharts(): array
    {
        return [
            'salesTrend' => ['labels' => [], 'totals' => [], 'counts' => []],
            'monthlySales' => ['labels' => [], 'values' => []],
            'stockFlow' => ['labels' => [], 'in' => [], 'out' => []],
            'branchSales' => ['labels' => [], 'values' => []],
            'topProducts' => ['labels' => [], 'values' => []],
            'categorySales' => ['labels' => [], 'values' => []],
        ];
    }

    private function buildCharts($user, ?int $branchId): array
    {
        $salesTrend = collect(range(6, 0))->map(function (int $daysAgo) use ($branchId) {
            $date = Carbon::today()->subDays($daysAgo);
            $base = Transaction::query()->whereDate('transaction_date', $date);

            if ($branchId) {
                $base->where('branch_id', $branchId);
            }

            return [
                'label' => $date->locale('id')->translatedFormat('D, d/m'),
                'total' => (float) (clone $base)->sum('total_price'),
                'count' => (clone $base)->count(),
            ];
        });

        $monthlySales = collect(range(5, 0))->map(function (int $monthsAgo) use ($branchId) {
            $start = Carbon::today()->subMonths($monthsAgo)->startOfMonth();
            $end = Carbon::today()->subMonths($monthsAgo)->endOfMonth();
            $base = Transaction::query()->whereBetween('transaction_date', [$start->toDateString(), $end->toDateString()]);

            if ($branchId) {
                $base->where('branch_id', $branchId);
            }

            return [
                'label' => $start->locale('id')->translatedFormat('M y'),
                'value' => (float) (clone $base)->sum('total_price'),
            ];
        });

        $stockFlow = collect(range(5, 0))->map(function (int $monthsAgo) use ($branchId) {
            $start = Carbon::today()->subMonths($monthsAgo)->startOfMonth();
            $end = Carbon::today()->subMonths($monthsAgo)->endOfMonth();
            $base = StockMovement::query()->whereBetween('movement_date', [$start->toDateString(), $end->toDateString()]);

            if ($branchId) {
                $base->where('branch_id', $branchId);
            }

            return [
                'label' => $start->locale('id')->translatedFormat('M y'),
                'in' => (int) (clone $base)->where('type', 'in')->sum('quantity'),
                'out' => (int) (clone $base)->whereIn('type', ['out', 'sale'])->sum('quantity'),
            ];
        });

        $branchSales = ['labels' => [], 'values' => []];
        if ($user->role === 'owner') {
            $branchSales = Transaction::query()
                ->join('branches', 'transactions.branch_id', '=', 'branches.id')
                ->select('branches.branch_name as label', DB::raw('SUM(transactions.total_price) as total'))
                ->groupBy('transactions.branch_id', 'branches.branch_name')
                ->orderByDesc('total')
                ->limit(8)
                ->get()
                ->pipe(fn ($rows) => [
                    'labels' => $rows->pluck('label')->all(),
                    'values' => $rows->pluck('total')->map(fn ($v) => (float) $v)->all(),
                ]);
        }

        $topProductsQuery = TransactionDetail::query()
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select('products.product_name as label', DB::raw('SUM(transaction_details.quantity) as total'))
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total')
            ->limit(10);

        if ($branchId) {
            $topProductsQuery->where('transactions.branch_id', $branchId);
        }

        $topProducts = $topProductsQuery->get()->pipe(fn ($rows) => [
            'labels' => $rows->pluck('label')->all(),
            'values' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all(),
        ]);

        $categoryQuery = TransactionDetail::query()
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select('categories.category_name as label', DB::raw('SUM(transaction_details.quantity) as total'))
            ->groupBy('categories.id', 'categories.category_name')
            ->orderByDesc('total');

        if ($branchId) {
            $categoryQuery->where('transactions.branch_id', $branchId);
        }

        $categorySales = $categoryQuery->get()->pipe(fn ($rows) => [
            'labels' => $rows->pluck('label')->all(),
            'values' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all(),
        ]);

        return [
            'salesTrend' => [
                'labels' => $salesTrend->pluck('label')->all(),
                'totals' => $salesTrend->pluck('total')->all(),
                'counts' => $salesTrend->pluck('count')->all(),
            ],
            'monthlySales' => [
                'labels' => $monthlySales->pluck('label')->all(),
                'values' => $monthlySales->pluck('value')->all(),
            ],
            'stockFlow' => [
                'labels' => $stockFlow->pluck('label')->all(),
                'in' => $stockFlow->pluck('in')->all(),
                'out' => $stockFlow->pluck('out')->all(),
            ],
            'branchSales' => $branchSales,
            'topProducts' => $topProducts,
            'categorySales' => $categorySales,
        ];
    }
}
