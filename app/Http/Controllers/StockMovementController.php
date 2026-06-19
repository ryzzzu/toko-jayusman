<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesUserBranch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    use ResolvesUserBranch;

    public function index()
    {
        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

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
        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

        $products = Product::orderBy('product_name')->get();

        return view('stock_movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        if ($request->type !== 'adjustment' && $request->quantity < 1) {
            return back()->with('error', 'Jumlah harus minimal 1.');
        }

        $branchCheck = $this->ensureBranchAssigned();
        if ($branchCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $branchCheck;
        }

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::beginTransaction();

        try {
            $stock = Stock::where('branch_id', $branchId)
                ->where('product_id', $request->product_id)
                ->lockForUpdate()
                ->first();

            if (!$stock) {
                $stock = Stock::create([
                    'branch_id' => $branchId,
                    'product_id' => $request->product_id,
                    'quantity' => 0,
                ]);
            }

            if ($request->type === 'in') {
                $stock->quantity += $request->quantity;
            }

            if ($request->type === 'out') {
                if ($stock->quantity < $request->quantity) {
                    DB::rollBack();

                    return back()->with('error', 'Stok tidak mencukupi.');
                }

                $stock->quantity -= $request->quantity;
            }

            if ($request->type === 'adjustment') {
                $stock->quantity = $request->quantity;
            }

            $stock->save();

            StockMovement::create([
                'branch_id' => $branchId,
                'product_id' => $request->product_id,
                'user_id' => $user->id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'movement_date' => now()->toDateString(),
            ]);

            $product = Product::find($request->product_id);

            ActivityLogger::log(
                'mutasi_stok',
                'Gudang ' . $user->name . ' melakukan ' . $request->type
                    . ' pada ' . ($product->product_name ?? 'produk')
                    . ' sebanyak ' . $request->quantity
            );

            DB::commit();

            return redirect()->route('stock-movements.index')
                ->with('success', 'Data pergerakan stok berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
