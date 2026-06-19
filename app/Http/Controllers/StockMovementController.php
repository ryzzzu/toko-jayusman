<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $movements = StockMovement::with(['branch', 'product', 'user']);

        if ($user->role !== 'owner') {
            $movements->where('branch_id', $user->branch_id);
        }

        $movements = $movements->latest()->get();

        return view('stock_movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();

        return view('stock_movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();

        if (!$user->branch_id) {
            return back()->with('error', 'Akun gudang belum terhubung ke cabang.');
        }

        $stock = Stock::firstOrCreate(
            [
                'branch_id' => $user->branch_id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => 0,
            ]
        );

        if ($request->type === 'in') {
            $stock->quantity += $request->quantity;
        }

        if ($request->type === 'out') {
            if ($stock->quantity < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }

            $stock->quantity -= $request->quantity;
        }

        if ($request->type === 'adjustment') {
            $stock->quantity = $request->quantity;
        }

        $stock->save();

        StockMovement::create([
            'branch_id' => $user->branch_id,
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'movement_date' => now()->toDateString(),
        ]);

        return redirect()->route('stock-movements.index')
            ->with('success', 'Data pergerakan stok berhasil disimpan.');
    }
}