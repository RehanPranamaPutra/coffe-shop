@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold text-center mb-4">Struk Pembelian</h2>
        <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>

        @if ($transaksi->promo)
            <p><strong>Promo:</strong> {{ $transaksi->promo->nama_promo }} ({{ $transaksi->promo->diskon }}%)</p>
        @endif

        <table class="w-full mt-4 text-sm border-t">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-1">Menu</th>
                    <th class="text-center py-1">Qty</th>
                    <th class="text-right py-1">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->items as $item)
                    <tr>
                        <td>{{ $item->menu->nama_menu }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->promo)
                                <small class="text-green-600">Diskon {{ $item->promo->nilai_diskon }}%</small>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="border-t mt-4 pt-2 text-sm">
            <p class="flex justify-between"><span>Total:</span> <span>Rp
                    {{ number_format($transaksi->total, 0, ',', '.') }}</span></p>
            <p class="flex justify-between"><span>Dibayar:</span> <span>Rp
                    {{ number_format($transaksi->dibayar, 0, ',', '.') }}</span></p>
            <p class="flex justify-between font-semibold"><span>Kembalian:</span> <span>Rp
                    {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span></p>
        </div>
    </div>
@endsection
