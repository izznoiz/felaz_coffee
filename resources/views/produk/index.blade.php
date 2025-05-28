<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- tombol tambah produk admin --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('produk.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Tambah Produk
                    </a>
                @endif

                {{-- Tombol Lihat Keranjang untuk Pelanggan --}}
                @if(auth()->user()->role === 'pelanggan')
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('cart.index') }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">
                            🛒 Lihat Keranjang
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($produks as $p)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <a href="{{ route('produk.show', $p->id) }}">
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                                    class="w-full h-48 object-cover mb-2">
                            </a>
                            <a href="{{ route('produk.show', $p->id) }}"
                                class="block text-lg font-semibold text-gray-800 hover:text-indigo-600">
                                <h3 class="text-lg font-semibold">{{ $p->nama }}</h3>
                            </a>
                            <p class="text-gray-700">Rp {{ number_format($p->harga) }}</p>
                            <p class="text-sm text-gray-500">{{ $p->deskripsi }}</p>

                            <div class="mt-3 flex space-x-2">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('produk.edit', $p->id) }}" class="text-blue-500 underline">Edit</a>

                                    <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 underline">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>