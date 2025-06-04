<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Detail Produk
        </h2>
    </x-slot> --}}
    <main class="pt-24">
        <div class="py-10 max-w-4xl mx-auto px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/2">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                        class="w-full h-64 object-cover">
                </div>

                <div class="p-6 md:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $produk->nama }}</h3>
                    <p class="text-gray-700 mb-4">{{ $produk->deskripsi }}</p>
                    <p class="text-2x1 text-green-600 font-semibold mb-6">Rp
                        {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <form action="{{ route('cart.add', $produk->id) }}" method="POST"
                        onsubmit="return handleAddToCart(event)">
                        @csrf
                        <div class="mb-2">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="1" required
                                class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block font-medium">Total Harga:</label>
                            <p id="total-price" class="text-lg font-semibold text-green-600">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Tambah Ke keranjang
                        </button>
                    </form>

                    <script>
                        const pricePerItem = {{ $produk->harga }};
                        const quantityInput = document.getElementById('quantity');
                        const totalPriceEl = document.getElementById('total-price');

                        function updateTotal() {
                            const qty = parseInt(quantityInput.value) || 1;
                            const total = qty * pricePerItem;
                            totalPriceEl.textContent = "Rp " + new Intl.NumberFormat('id-ID').format(total);
                        }
                        quantityInput.addEventListener('input', updateTotal);
                        // Panggil saat halaman pertama kali dimuat
                        document.addEventListener('DOMContentLoaded', updateTotal);
                    </script>
                    <script>
                        function handleAddToCart(event) {
                            event.preventDefault(); // Hindari submit form biasa

                            const form = event.target;

                            fetch(form.action, {
                                method: 'POST',
                                body: new FormData(form),
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            })
                                .then(response => {
                                    if (response.ok) {
                                        alert('Produk berhasil ditambahkan ke keranjang!');
                                        window.location.href = "{{ route('produk.index') }}"; // atau arahkan kembali ke produk jika pakai route tertentu
                                    } else {
                                        return response.json().then(data => {
                                            throw new Error(data.message || 'Terjadi kesalahan.');
                                        });
                                    }
                                })
                                .catch(error => {
                                    alert('Gagal menambahkan ke keranjang: ' + error.message);
                                });

                            return false;
                        }
                    </script>

                    <br>

                    <a href="{{ route('produk.index') }}"
                        class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        ← Kembali ke daftar produk
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>