<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Detail Pesanan - Batch #{{ $batch->id }}
        </h2>
    </x-slot>

    <div class="bg-white p-4 rounded shadow mb-4">
        <p><strong>Nama Pemesan:</strong> {{ $batch->user->name }}</p>
        <p><strong>Status:</strong> 
            <span class="capitalize">{{ $batch->status }}</span>
        </p>
        <p><strong>Total Harga:</strong> Rp{{ number_format($batch->total_price, 0, ',', '.') }}</p>

        <form action="{{ route('admin.orders.updateStatus', $batch->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PATCH')
            <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status:</label>
            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded">
                <option value="pending" @selected($batch->status === 'pending')>Menunggu Konfirmasi</option>
                <option value="diproses" @selected($batch->status === 'diproses')>Diproses</option>
                <option value="dikirim" @selected($batch->status === 'dikirim')>Dikirim</option>
                <option value="selesai" @selected($batch->status === 'selesai')>Selesai</option>
            </select>
            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded">Update</button>
        </form>
    </div>

    <h3 class="text-lg font-semibold mb-2">Daftar Produk:</h3>
    <div class="space-y-4">
        @foreach($batch->orders as $order)
            <div class="border p-4 rounded-lg bg-gray-50">
                <p>{{ $order->product->name }} x {{ $order->quantity }}</p>
                <p class="text-sm text-gray-600">Harga Satuan: Rp{{ number_format($order->product->harga, 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">← Kembali ke daftar</a>
</x-app-layout>
