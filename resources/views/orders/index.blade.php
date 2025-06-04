<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight tracking-wide">
            {{ __('Daftar Pesanan Anda') }}
        </h2>
    </x-slot> -->
    

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 3.152a1.2 1.2 0 1 1-1.697-1.697l3.152-2.651-3.152-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-3.152a1.2 1.2 0 1 1 1.697 1.697L11.697 10l3.152 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @if($ordersBatches->isEmpty())
                <div class="text-center py-10">
                    <p class="text-gray-600 text-lg">Anda belum memiliki pesanan.</p>
                    <a href="{{ route('produk.index') }}" class="mt-4 inline-block bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-8">
                    @foreach($ordersBatches as $batch)
                        <div class="bg-stone-50 border border-stone-200 rounded-xl shadow-md p-6">
                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-stone-200">
                                <div>
                                    <h3 class="text-xl font-bold text-amber-900">Pesanan #{{ $batch->id }}</h3>
                                    <p class="text-sm text-stone-600">Tanggal Pesan: {{ $batch->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-700">Total: <span class="text-2xl font-extrabold text-amber-700">Rp {{ number_format($batch->total_price) }}</span></p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $batch->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($batch->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($batch->status) }}
                                    </span>
                                </div>
                            </div>

                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Detail Item:</h4>
                            <div class="space-y-4">
                                @foreach($batch->orders as $item) {{-- $batch->orders adalah relasi ke Order (sebagai OrderItem) --}}
                                    <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                        @if($item->product && $item->product->gambar)
                                            <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" class="w-16 h-16 object-cover rounded-lg shadow">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-lg font-medium text-gray-900">{{ $item->product->nama ?? 'Produk tidak ditemukan' }}</p>
                                            <p class="text-sm text-gray-600">Kuantitas: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-md font-semibold text-gray-700">Rp {{ number_format($item->total_price) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>