<x-app-layout>
    

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.orders.export', ['status' => request('status', 'all')]) }}"
            class="inline-block mb-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            📄 Export PDF
        </a>


        <form method="GET" class="mb-4">
            <label for="status" class="mr-2 font-semibold">Filter Status:</label>
            <select name=" status" id="status" onchange="this.form.submit()" class="rounded border px-3 py-2">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>

        <div class="space-y-8">
            @foreach($batches as $batch)
                <div class="bg-stone-50 border border-stone-200 rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-stone-200">
                        <div>
                            <h3 class="text-xl font-bold text-amber-900">Pesanan #{{ $batch->id }}</h3>
                            <p class="text-sm text-stone-600">Tanggal Pesan: {{ $batch->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="text-sm text-stone-600">Pelanggan: {{ $batch->user->name }}</p>
                        </div>
                        <div class="text-right space-y-1">
                            <p class="text-lg font-semibold text-gray-700">
                                Total:
                                <span class="text-2xl font-extrabold text-amber-700">
                                    Rp {{ number_format($batch->total_price, 0, ',', '.') }}
                                </span>
                            </p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($batch->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($batch->status === 'diproses') bg-blue-100 text-blue-800
                            @elseif($batch->status === 'dikirim') bg-indigo-100 text-indigo-800
                            @elseif($batch->status === 'selesai') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                            @endif
                        ">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Detail Item:</h4>
                    <div class="space-y-4">
                        @foreach($batch->orders as $item)
                            <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                @if($item->product && $item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                        alt="{{ $item->product->nama }}" class="w-16 h-16 object-cover rounded-lg shadow">
                                @else
                                    <div
                                        class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">
                                        No Image
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-lg font-medium text-gray-900">
                                        {{ $item->product->nama ?? 'Produk tidak ditemukan' }}</p>
                                    <p class="text-sm text-gray-600">Kuantitas: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-md font-semibold text-gray-700">Rp
                                        {{ number_format($item->total_price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.orders.show', $batch->id) }}"
                            class="inline-block text-sm text-blue-600 hover:underline">
                            Lihat detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $batches->links() }}
        </div>
    </div>
</x-app-layout>