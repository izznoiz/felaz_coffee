<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight tracking-wide">
            {{ __('Menu Felaz Coffee') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-8">

            {{-- Tombol untuk Admin: Tambah Produk --}}
            @if(auth()->user()->role === 'admin')
                <div class="mb-6 flex justify-start">
                    <a href="{{ route('produk.create') }}"
                        class="bg-amber-700 hover:bg-amber-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out shadow-md">
                        ☕ Tambah Menu Baru Felaz
                    </a>
                </div>
            @endif

            {{-- Tombol untuk Pelanggan: Lihat Keranjang --}}
            @if(auth()->user()->role === 'pelanggan')
                <div class="flex justify-end mb-6">
                    <a href="{{ route('cart.index') }}"
                        class="bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-3 rounded-lg transition duration-300 ease-in-out shadow-md">
                        🛒 Lihat Pesanan Saya
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($produks as $p)
                    <div
                        class="bg-stone-50 border border-stone-200 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('produk.show', $p->id) }}">
                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                                class="w-full h-64 object-cover object-center border-b border-stone-200">
                        </a>
                        <div class="p-6">
                            <a href="{{ route('produk.show', $p->id) }}"
                                class="block text-xl font-bold text-amber-900 hover:text-amber-700 mb-2 leading-tight">
                                {{ $p->nama }}
                            </a>
                            <p class="text-2xl font-extrabold text-amber-700 mb-2">Rp {{ number_format($p->harga) }}</p>
                            <p class="text-sm text-stone-600 leading-relaxed mb-4">{{ Str::limit($p->deskripsi, 100) }}</p>

                            <div class="pt-4 border-t border-stone-200 mt-auto flex justify-between items-center">
                                @if(auth()->user()->role === 'admin')
                                    <div class="flex space-x-4">
                                        <a href="{{ route('produk.edit', $p->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium transition duration-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                @if(auth()->user()->role === 'pelanggan')
                                    <form action="{{ route('cart.add', $p->id) }}" method="POST"
                                        onsubmit="return handleAddToCart(event)" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded-full text-sm transition duration-300 ease-in-out flex items-center space-x-2">
                                            <span>+ Tambah ke Keranjang</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
