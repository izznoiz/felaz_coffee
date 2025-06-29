<x-app-layout>
    <main class="pt-24 bg-gradient-to-b from-[#f3f4f6] to-[#e5e7eb] min-h-screen">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
                <!-- FULL LEFT IMAGE -->
                <div class="h-[500px] md:h-auto">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                        class="w-full h-full object-cover object-center" />
                </div>

                <!-- PRODUCT DETAILS -->
                <div class="p-8 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 font-serif mb-4">{{ $produk->nama }}</h1>
                        <p class="text-gray-600 text-base mb-6 leading-relaxed">{{ $produk->deskripsi }}</p>
                        <p class="text-2xl text-amber-600 font-semibold mb-6">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('cart.add', $produk->id) }}" method="POST" onsubmit="return handleAddToCart(event)" class="space-y-4">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="1" required
                                class="mt-1 w-24 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700">Total Harga:</label>
                            <p id="total-price" class="text-lg font-semibold text-green-600">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition font-medium">
                            Tambah ke Keranjang
                        </button>
                    </form>

                    <a href="{{ route('produk.index') }}"
                        class="mt-6 inline-block text-center bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                        ← Kembali ke Daftar Produk
                    </a>
                </div>
            </div>
        </div>
    </main>

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
        document.addEventListener('DOMContentLoaded', updateTotal);

        function handleAddToCart(event) {
            event.preventDefault();

            const form = event.target;

            // Show loading
            Swal.fire({
                title: 'Menambahkan ke keranjang...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

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
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Produk berhasil ditambahkan ke keranjang',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'custom-swal'
                    }
                }).then(() => {
                    window.location.href = "{{ route('produk.index') }}";
                });
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || 'Terjadi kesalahan.');
                });
            }
        })

                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menambahkan ke keranjang: ' + error.message,
                        customClass: {
                            popup: 'custom-swal'
                        }
                    });
                });


            return false;
        }
    </script>
</x-app-layout>
