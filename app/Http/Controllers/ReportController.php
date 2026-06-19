<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesUserBranch;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use ResolvesUserBranch;

    public function transactions(Request $request)
    {
        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

        $user = Auth::user();

        $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $transactions = Transaction::with(['branch', 'cashier']);

        if ($user->role !== 'owner') {
            $transactions->where('branch_id', $user->branch_id);
        } elseif ($request->filled('branch_id')) {
            $transactions->where('branch_id', $request->branch_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $transactions->whereBetween('transaction_date', [
                $request->start_date,
                $request->end_date,
            ]);
        }

        $transactions = $transactions->orderBy('transaction_date', 'desc')->get();
        $branches = Branch::orderBy('branch_name')->get();

        return view('reports.transactions', compact('transactions', 'branches'));
    }

    public function stocks(Request $request)
    {
        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

        $user = Auth::user();

        $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $branches = Branch::orderBy('branch_name')->get();
        $reportMode = 'snapshot';

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $reportMode = 'movements';

            $movements = StockMovement::with(['branch', 'product.category', 'user']);

            if ($user->role !== 'owner') {
                $movements->where('branch_id', $user->branch_id);
            } elseif ($request->filled('branch_id')) {
                $movements->where('branch_id', $request->branch_id);
            }

            $movements = $movements
                ->whereBetween('movement_date', [$request->start_date, $request->end_date])
                ->orderBy('movement_date', 'desc')
                ->get();

            return view('reports.stocks', compact('branches', 'movements', 'reportMode'));
        }

        $stocks = Stock::with(['branch', 'product.category']);

        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        } elseif ($request->filled('branch_id')) {
            $stocks->where('branch_id', $request->branch_id);
        }

        $stocks = $stocks->get();

        return view('reports.stocks', compact('stocks', 'branches', 'reportMode'));
    }
}
