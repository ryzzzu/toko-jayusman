<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesUserBranch;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    use ResolvesUserBranch;

    public function index()
    {
        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

        $user = Auth::user();

        $stocks = Stock::with(['branch', 'product.category']);

        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        }

        $stocks = $stocks->get();

        return view('stocks.index', compact('stocks'));
    }
}
