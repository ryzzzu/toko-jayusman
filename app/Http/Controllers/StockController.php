<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stocks = Stock::with(['branch', 'product.category']);

        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        }

        $stocks = $stocks->get();

        return view('stocks.index', compact('stocks'));
    }
}