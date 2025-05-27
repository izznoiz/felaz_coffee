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
                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="border rounded p-4 shadow-sm hover:shadow-md transition flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-600">
                                        Total Harga:
                                        <span class="font-medium">
                                            Rp{{ number_format($item->quantity * $item->product->harga, 0, ',', '.') }}
                                        </span>
                                    </p>
                                </div>

                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
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
                        <form action="{{ route('cart.checkout') }}" method="POST" onsubmit="return confirm('Lanjutkan ke checkout?');">
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
