<x-app-layout>
    <main class="pt-24 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($produks as $p)
                    @php
                        $user = auth()->user();
                        $route = $user && $user->role === 'admin'
                            ? route('produk.edit', $p->id)
                            : route('produk.show', $p->id);
                    @endphp

                    <div class="relative group bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-300 border border-gray-300">
                        <a href="{{ $route }}" class="block">
                            <div class="h-96 overflow-hidden">
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        </a>

                        <div class="absolute bottom-0 w-full bg-gradient-to-t from-black/80 to-black/20 text-white px-6 py-4 backdrop-blur-sm">
                            <h3 class="text-xl font-bold font-serif mb-1 group-hover:text-amber-400 transition">{{ $p->nama }}</h3>
                            <p class="text-md text-amber-300 font-semibold">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-100 mt-1">{{ \Illuminate\Support\Str::limit($p->deskripsi, 80) }}</p>

                            @if(auth()->user()->role === 'admin')
                                <div class="flex justify-between items-center mt-3 text-sm">
                                    <a href="{{ route('produk.edit', $p->id) }}" class="hover:text-blue-400 underline">✎ Edit</a>
                                    <form action="{{ route('produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-400 underline">🗑 Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-app-layout>
