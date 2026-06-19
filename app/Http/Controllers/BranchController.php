<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $branch = Branch::create([
                'branch_name' => $request->branch_name,
                'city' => $request->city,
                'address' => $request->address,
            ]);

            foreach (Product::all() as $product) {
                Stock::create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'quantity' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('branches.index')
                ->with('success', 'Cabang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $branch->update([
            'branch_name' => $request->branch_name,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        if ($branch->users()->exists()) {
            return redirect()->route('branches.index')
                ->with('error', 'Cabang tidak dapat dihapus karena masih memiliki pengguna.');
        }

        if (Transaction::where('branch_id', $branch->id)->exists()) {
            return redirect()->route('branches.index')
                ->with('error', 'Cabang tidak dapat dihapus karena masih memiliki riwayat transaksi.');
        }

        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}
