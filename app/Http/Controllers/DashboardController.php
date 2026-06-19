<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesUserBranch;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use ResolvesUserBranch;

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            $totalBranches = Branch::count();
            $totalProducts = Product::count();
            $totalTransactions = Transaction::count();
            $totalIncome = Transaction::sum('total_price');
            $totalStock = Stock::sum('quantity');

            $lowStocks = Stock::with(['branch', 'product'])
                ->where('quantity', '<=', 10)
                ->orderBy('quantity', 'asc')
                ->limit(5)
                ->get();

            $latestTransactions = Transaction::with(['branch', 'cashier'])
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'totalBranches',
                'totalProducts',
                'totalTransactions',
                'totalIncome',
                'totalStock',
                'lowStocks',
                'latestTransactions'
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
                'branchWarning' => true,
            ]);
        }

        $branchId = $user->branch_id;

        $totalProducts = Product::count();
        $totalTransactions = Transaction::where('branch_id', $branchId)->count();
        $totalIncome = Transaction::where('branch_id', $branchId)->sum('total_price');
        $totalStock = Stock::where('branch_id', $branchId)->sum('quantity');

        $lowStocks = Stock::with(['branch', 'product'])
            ->where('branch_id', $branchId)
            ->where('quantity', '<=', 10)
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get();

        $latestTransactions = Transaction::with(['branch', 'cashier'])
            ->where('branch_id', $branchId)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'totalIncome',
            'totalStock',
            'lowStocks',
            'latestTransactions'
        ));
    }
}
