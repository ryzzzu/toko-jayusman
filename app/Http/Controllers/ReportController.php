<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $user = Auth::user();

        $transactions = Transaction::with(['branch', 'cashier']);

        if ($user->role !== 'owner') {
            $transactions->where('branch_id', $user->branch_id);
        }

        if ($request->filled('branch_id') && $user->role === 'owner') {
            $transactions->where('branch_id', $request->branch_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $transactions->whereBetween('transaction_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $transactions = $transactions->get();
        $branches = Branch::all();

        return view('reports.transactions', compact('transactions', 'branches'));
    }

    public function stocks(Request $request)
    {
        $user = Auth::user();

        $stocks = Stock::with(['branch', 'product.category']);

        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        }

        if ($request->filled('branch_id') && $user->role === 'owner') {
            $stocks->where('branch_id', $request->branch_id);
        }

        $stocks = $stocks->get();
        $branches = Branch::all();

        return view('reports.stocks', compact('stocks', 'branches'));
    }
}