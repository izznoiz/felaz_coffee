<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Dashboard Admin - Semua Pesanan
        </h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($batches as $batch)
            <div class="mb-4 p-4 bg-white rounded-lg shadow border">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <p class="text-lg font-semibold">Batch #{{ $batch->id }}</p>
                        <p class="text-sm text-gray-600">Nama: {{ $batch->user->name }}</p>
                        <p class="text-sm text-gray-600">Total: Rp{{ number_format($batch->total_price, 0, ',', '.') }}</p>
                    </div>
                    <span class="
                        px-3 py-1 rounded-full text-sm font-medium
                        @if($batch->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($batch->status === 'diproses') bg-blue-100 text-blue-800
                        @elseif($batch->status === 'dikirim') bg-indigo-100 text-indigo-800
                        @elseif($batch->status === 'selesai') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ ucfirst($batch->status) }}
                    </span>
                </div>
                <a href="{{ route('admin.orders.show', $batch->id) }}"
                   class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                    Lihat detail
                </a>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $batches->links() }}
        </div>
    </div>
</x-app-layout>
