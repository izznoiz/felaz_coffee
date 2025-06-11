<x-app-layout>
    <main class="pt-16 bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-100 min-h-screen relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-32 h-32 bg-amber-400 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-orange-400 rounded-full blur-2xl animate-pulse delay-1000"></div>
            <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-yellow-400 rounded-full blur-3xl animate-pulse delay-2000"></div>
        </div>

        <!-- Hero Section -->
        <div class="relative z-10 text-center py-16 mb-12">
            <div class="max-w-4xl mx-auto px-6">
                <h1 class="text-5xl md:text-7xl font-bold bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent mb-6 font-serif">
                    Menu Spesial
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 font-light leading-relaxed">
                    Nikmati koleksi minuman premium kami yang dibuat dengan cinta dan kualitas terbaik
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 lg:gap-12">
                @foreach($produks as $index => $p)
                    @php
                        $user = auth()->user();
                        $route = $user && $user->role === 'admin'
                            ? route('produk.edit', $p->id)
                            : route('produk.show', $p->id);
                    @endphp

                    <div class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2" 
                         style="animation: fadeInUp 0.6s ease-out {{ $index * 0.1 }}s both;">
                        <!-- Product Card -->
                        <div class="bg-white/80 backdrop-blur-lg rounded-3xl overflow-hidden shadow-2xl hover:shadow-amber-500/20 border border-white/50 relative">
                            
                            <!-- Image Container -->
                            <a href="{{ $route }}" class="block relative overflow-hidden">
                                <div class="h-80 relative">
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                    
                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            </a>

                            <!-- Content Section -->
                            <div class="p-6 relative">
                                <!-- Title -->
                                <h3 class="text-2xl font-bold text-gray-800 mb-3 font-serif group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $p->nama }}
                                </h3>
                                
                                <!-- Price -->
                                <div class="flex items-center mb-4">
                                    <span class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <!-- Description -->
                                <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                                    {{ \Illuminate\Support\Str::limit($p->deskripsi, 100) }}
                                </p>

                                <!-- Action Button -->
                                <div class="flex items-center justify-between">
                                    <a href="{{ $route }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </div>

                                <!-- Admin Controls -->
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                    <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                                        <a href="{{ route('produk.edit', $p->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" 
                                              onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Decorative Corner -->
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-amber-400/20 to-transparent rounded-bl-3xl"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bottom CTA Section -->
        <div class="relative z-10 bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 py-16 mt-16">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 font-serif">
                    Rasakan Kelezatan Sejati
                </h2>
                <p class="text-xl text-amber-100 mb-8 leading-relaxed">
                    Setiap tegukan adalah perjalanan rasa yang tak terlupakan
                </p>
                <p class="inline-flex items-center px-8 py-4 bg-white text-amber-600 font-bold rounded-full shadow-2xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 18a2 2 0 11-4 0 2 2 0 014 0zM9 18a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Pesan Sekarang
                </p>
            </div>
        </div>
    </main>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
        
        .backdrop-blur-lg {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</x-app-layout>