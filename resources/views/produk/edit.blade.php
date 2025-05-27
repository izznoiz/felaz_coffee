<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                <input type="text" name="nama" id="nama" value="{{ $produk->nama }}" class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full border border-gray-300 p-2 rounded" required>{{ $produk->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700 font-medium mb-2">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ $produk->harga }}" class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-medium mb-2">Gambar (biarkan kosong jika tidak diubah)</label>
                <input type="file" name="gambar" id="gambar" class="w-full">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Current image" class="mt-2 h-32 rounded">
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

