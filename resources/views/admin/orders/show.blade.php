<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-amber-900 leading-tight">
            Detail Pesanan #{{ $batch->id }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 space-y-6">
        
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Informasi Pemesan --}}
        <div class="bg-white p-6 rounded-xl shadow border border-stone-200 space-y-2">
            <p class="text-lg"><strong class="text-gray-700">Nama Pemesan:</strong> {{ $batch->user->name }}</p>
            <p class="text-lg">
                <strong class="text-gray-700">Status:</strong>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                    @if($batch->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($batch->status === 'diproses') bg-blue-100 text-blue-800
                    @elseif($batch->status === 'dikirim') bg-indigo-100 text-indigo-800
                    @elseif($batch->status === 'selesai') bg-green-100 text-green-800
                    @else bg-gray-200 text-gray-700 @endif">
                    {{ ucfirst($batch->status) }}
                </span>
            </p>
            <p class="text-lg"><strong class="text-gray-700">Total Harga:</strong> <span
                    class="text-amber-800 font-semibold">Rp{{ number_format($batch->total_price, 0, ',', '.') }}</span>
            </p>

            {{-- Form Update Status --}}
            <form action="{{ route('admin.orders.updateStatus', $batch->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PATCH')
                <label for="status" class="block mb-1 font-medium text-gray-700">Ubah Status:</label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-amber-500">
                    <option value="pending" @selected($batch->status === 'pending')>Menunggu Konfirmasi</option>
                    <option value="diproses" @selected($batch->status === 'diproses')>Diproses</option>
                    <option value="dikirim" @selected($batch->status === 'dikirim')>Dikirim</option>
                    <option value="selesai" @selected($batch->status === 'selesai')>Selesai</option>
                </select>
                <button type="submit"
                    class="mt-3 bg-amber-700 hover:bg-amber-800 text-white px-5 py-2 rounded-lg font-semibold transition">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Daftar Produk --}}
        <div class="bg-white p-6 rounded-xl shadow border border-stone-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Produk:</h3>

            <div class="space-y-4">
                @foreach($batch->orders as $order)
                    <div class="flex items-center space-x-4 border-b last:border-b-0 pb-4 last:pb-0">
                        {{-- Gambar produk --}}
                        @if($order->product && $order->product->gambar)
                            <img src="{{ asset('storage/' . $order->product->gambar) }}" alt="{{ $order->product->name }}"
                                class="w-20 h-20 object-cover rounded-lg shadow">
                        @else
                            <div
                                class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded-lg text-gray-500 text-xs">
                                No Image
                            </div>
                        @endif

                        {{-- Info produk --}}
                        <div class="flex-1">
                            <p class="text-lg font-semibold text-amber-900">
                                {{ $order->product->nama ?? 'Produk tidak ditemukan' }}
                            </p>
                            <p class="text-sm text-gray-600">Jumlah: {{ $order->quantity }}</p>
                            <p class="text-sm text-gray-600">Harga Satuan:
                                Rp{{ number_format($order->product->harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="text-right">
                            <p class="text-md font-bold text-gray-800">Subtotal:</p>
                            <p class="text-md font-semibold text-amber-800">
                                Rp{{ number_format($order->quantity * $order->product->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="text-center">
            <a href="{{ route('admin.orders.index') }}" class="text-amber-700 hover:underline text-sm font-medium">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>

    </div>
</x-app-layout>