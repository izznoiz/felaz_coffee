<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Daftar Pesanan Anda
        </h2>
    </x-slot>

    @if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-600">Kamu belum memiliki pesanan.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 mx-8">
            @foreach ($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-5 flex flex-col">
                    <div class="flex items-center mb-3">
                        <span class="font-bold text-lg">Pesanan #{{ $order->id }}</span>
                        <span class="ml-auto px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-700
                            @endif
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <img src="{{ asset('storage/' . $order->product->gambar) }}" alt="{{ $order->product->nama }}" class="h-40 w-full object-cover rounded mb-4">
                    <div class="mb-2">
                        <h3 class="text-md font-semibold">{{ $order->product->nama }}</h3>
                        <p class="text-gray-600 text-sm">{{ $order->product->deskripsi }}</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto">
                        <span class="text-gray-700 text-sm">Jumlah: {{ $order->quantity ?? 1 }}</span>
                        <span class="font-semibold text-green-700">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-app-layout>