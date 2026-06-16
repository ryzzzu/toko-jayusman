<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['branch_name' => 'Mini Market Cianjur', 'city' => 'Cianjur', 'address' => 'Jl. Raya Cianjur'],
            ['branch_name' => 'Mini Market Bandung', 'city' => 'Bandung', 'address' => 'Jl. Raya Bandung'],
            ['branch_name' => 'Mini Market Sukabumi', 'city' => 'Sukabumi', 'address' => 'Jl. Raya Sukabumi'],
            ['branch_name' => 'Mini Market Bogor', 'city' => 'Bogor', 'address' => 'Jl. Raya Bogor'],
            ['branch_name' => 'Mini Market Jakarta', 'city' => 'Jakarta', 'address' => 'Jl. Raya Jakarta'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }

        User::create([
            'name' => 'Bapak Jayusman',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'branch_id' => null,
        ]);

        User::create([
            'name' => 'Manager Cianjur',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Supervisor Cianjur',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Kasir Cianjur',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Gudang Cianjur',
            'email' => 'warehouse@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
            'branch_id' => 1,
        ]);

        $category = Category::create([
            'category_name' => 'Minuman',
        ]);

        $products = [
            [
                'category_id' => $category->id,
                'product_name' => 'Aqua 600ml',
                'barcode' => 'BRG001',
                'purchase_price' => 3000,
                'selling_price' => 4000,
                'unit' => 'pcs',
            ],
            [
                'category_id' => $category->id,
                'product_name' => 'Teh Botol',
                'barcode' => 'BRG002',
                'purchase_price' => 4000,
                'selling_price' => 6000,
                'unit' => 'pcs',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            foreach (Branch::all() as $branch) {
                Stock::create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'quantity' => 50,
                ]);
            }
        }
    }
}