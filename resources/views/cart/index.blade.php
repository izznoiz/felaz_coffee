<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if($cartItems->isEmpty())
                    <p class="text-gray-600">Belum ada pesanan yang dibuat.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($cartItems as $item)
                            <div
                                class="bg-white border border-stone-200 rounded-xl shadow-sm hover:shadow-md transition p-5 flex items-center space-x-4">
                                {{-- Gambar Produk --}}
                                @if($item->product && $item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                        alt="{{ $item->product->nama }}" class="w-20 h-20 object-cover rounded-lg shadow">
                                @else
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 text-sm">
                                        No Image
                                    </div>
                                @endif

                                {{-- Info Produk --}}
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-amber-900">
                                        {{ $item->product->nama ?? 'Produk tidak ditemukan' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-700">
                                        Total Harga:
                                        <span class="font-semibold text-amber-700">
                                            Rp{{ number_format($item->quantity * $item->product->harga, 0, ',', '.') }}
                                        </span>
                                    </p>
                                </div>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>


                    {{-- Total & Checkout Button --}}
                    <div class="mt-6 flex justify-between items-center border-t pt-4">
                        <div class="text-xl font-semibold">
                            Total: Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST"
                            onsubmit="return confirm('Lanjutkan ke checkout?');">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Checkout
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>