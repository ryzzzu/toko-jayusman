<x-app-layout>
    <x-slot name="header">
        <h2>Detail Transaksi</h2>
    </x-slot>

    <div style="padding: 20px;">
        <h3>{{ $transaction->transaction_code }}</h3>
        <p>Tanggal: {{ $transaction->transaction_date }}</p>
        <p>Cabang: {{ $transaction->branch->branch_name }}</p>
        <p>Kasir: {{ $transaction->cashier->name }}</p>

        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

            @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <h3>Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
        <p>Bayar: Rp {{ number_format($transaction->payment, 0, ',', '.') }}</p>
        <p>Kembalian: Rp {{ number_format($transaction->change, 0, ',', '.') }}</p>

        <button onclick="window.print()">Cetak</button>
    </div>
</x-app-layout>