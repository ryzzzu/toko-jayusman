<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::with(['branch', 'cashier']);

        if ($user->role !== 'owner') {
            $transactions->where('branch_id', $user->branch_id);
        }

        $transactions = $transactions->latest()->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::with('stocks')->get();

        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'payment' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::beginTransaction();

        try {
            $totalPrice = 0;
            $items = [];

            foreach ($request->product_id as $index => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = $request->quantity[$index];

                $stock = Stock::where('branch_id', $branchId)
                    ->where('product_id', $productId)
                    ->first();

                if (!$stock || $stock->quantity < $quantity) {
                    DB::rollBack();
                    return back()->with('error', 'Stok produk ' . $product->product_name . ' tidak mencukupi.');
                }

                $subtotal = $product->selling_price * $quantity;
                $totalPrice += $subtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->selling_price,
                    'subtotal' => $subtotal,
                    'stock' => $stock,
                ];
            }

            if ($request->payment < $totalPrice) {
                DB::rollBack();
                return back()->with('error', 'Pembayaran kurang.');
            }

            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . date('YmdHis'),
                'branch_id' => $branchId,
                'cashier_id' => $user->id,
                'transaction_date' => now()->toDateString(),
                'total_price' => $totalPrice,
                'payment' => $request->payment,
                'change' => $request->payment - $totalPrice,
            ]);

            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['stock']->quantity -= $item['quantity'];
                $item['stock']->save();

                StockMovement::create([
                    'branch_id' => $branchId,
                    'product_id' => $item['product']->id,
                    'user_id' => $user->id,
                    'type' => 'sale',
                    'quantity' => $item['quantity'],
                    'description' => 'Penjualan transaksi ' . $transaction->transaction_code,
                    'movement_date' => now()->toDateString(),
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['branch', 'cashier', 'details.product']);

        return view('transactions.show', compact('transaction'));
    }
}