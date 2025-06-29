
<x-app-layout>
    

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifikasi Real-time -->
            <div id="notification-area" class="mb-6 hidden" style="position: fixed !important; top: 1rem; right: 1rem; z-index: 9999; max-width: 400px; margin-bottom: 0 !important;">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline" id="notification-text"></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg onclick="hideNotification()" class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            </div>

        <a href="{{ route('admin.orders.export', ['status' => request('status', 'all')]) }}"
            class="inline-block mb-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            📄 Export PDF
        </a>


        <form class="pt-6 pb-6" method="GET" class="mb-4">
            <label for="status" class="mr-2 font-semibold">Filter Status:</label>
            <select name=" status" id="status" onchange="this.form.submit()" class="rounded border px-3 py-2">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>

        <div class="space-y-8">
            @foreach($batches as $batch)
                <div class="bg-stone-50 border border-stone-200 rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-stone-200">
                        <div>
                            <h3 class="text-xl font-bold text-amber-900">Pesanan #{{ $batch->id }}</h3>
                            <p class="text-sm text-stone-600">Tanggal Pesan: {{ $batch->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="text-sm text-stone-600">Pelanggan: {{ $batch->user->name ?? "" }}</p>
                        </div>
                        <div class="text-right space-y-1">
                            <p class="text-lg font-semibold text-gray-700">
                                Total:
                                <span class="text-2xl font-extrabold text-amber-700">
                                    Rp {{ number_format($batch->total_price, 0, ',', '.') }}
                                </span>
                            </p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($batch->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($batch->status === 'diproses') bg-blue-100 text-blue-800
                            @elseif($batch->status === 'dikirim') bg-indigo-100 text-indigo-800
                            @elseif($batch->status === 'selesai') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                            @endif
                        ">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Detail Item:</h4>
                    <div class="space-y-4">
                        @foreach($batch->orders as $item)
                            <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                @if($item->product && $item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                        alt="{{ $item->product->nama }}" class="w-16 h-16 object-cover rounded-lg shadow">
                                @else
                                    <div
                                        class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">
                                        No Image
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-lg font-medium text-gray-900">
                                        {{ $item->product->nama ?? 'Produk tidak ditemukan' }}</p>
                                    <p class="text-sm text-gray-600">Kuantitas: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-md font-semibold text-gray-700">Rp
                                        {{ number_format($item->total_price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.orders.show', $batch->id) }}"
                            class="inline-block text-sm text-blue-600 hover:underline">
                            Lihat detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $batches->links() }}
        </div>
    </div>

    {{-- <audio id="notification-sound" preload="auto">Add commentMore actions
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('sounds/notification.wav') }}" type="audio/wav">
    </audio> --}}

    @push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Initialize Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });

        // Debug connection
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected successfully!');
        });

        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });

        // Subscribe to admin-orders channel
        const channel = pusher.subscribe('admin-orders');

        // Debug channel subscription
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to admin-orders channel');
        });

        channel.bind('pusher:subscription_error', function(error) {
            console.error('Subscription error:', error);
        });

        // // Listen for new-order event
        // channel.bind('new-order', function(data) {
        //     console.log('NEW ORDER RECEIVED:', data);
        //     // Update statistics
        //     updateStatistics();
            
        //     // Add new order to table
        //     addNewOrderToTable(data);

        //     createLiveIndicator()
            
        //     // Show notification
        //     // showNotification(`${data.message} - Order #${data.order_id} dari ${data.customer_name}`);
            
        //     // Play notification sound
        //     // playNotificationSound();
            
        //     // Flash the live indicator
        //     flashLiveIndicator();
        // });

       function addNewOrderToTable(data) {
    const ordersContainer = document.querySelector('.space-y-8');
    if (!ordersContainer) {
        console.warn('Orders container not found');
        return;
    }
    
    // Format tanggal
    const orderDate = new Date().toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Generate detail items HTML
    let itemsHTML = '';
    if (data.items && Array.isArray(data.items) && data.items.length > 0) {
        console.log('Items found:', data.items); // Debug log
        itemsHTML = data.items.map(item =>  `
            <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                ${item.product_gambar ? 
                    `<img src="/storage/${item.product_gambar}" alt="${item.product_nama}" class="w-16 h-16 object-cover rounded-lg shadow">` :
                    `<div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">No Image</div>`
                }
                <div class="flex-1">
                    <p class="text-lg font-medium text-gray-900">${item.product_nama || 'Produk tidak ditemukan'}</p>
                    <p class="text-sm text-gray-600">Kuantitas: ${item.quantity}</p>
                </div>
                <div class="text-right">
                    <p class="text-md font-semibold text-gray-700">Rp ${(item.total_price || 0).toLocaleString('id-ID')}</p>
                </div>
            </div>
        `).join('');
    } else {
        console.log('No items found or items is not an array:', data.items); // Debug log
        itemsHTML = '<p class="text-gray-500">Detail item tidak tersedia</p>';
    }
    
    const newOrderHTML = `
        <div id="order-${data.order_id}" class="bg-yellow-50 border-2 border-yellow-300 rounded-xl shadow-md p-6 animate-pulse">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-stone-200">
                <div>
                    <h3 class="text-xl font-bold text-amber-900">
                        Pesanan #${data.order_id} 
                        <span class="text-red-500 text-sm font-normal">(BARU!)</span>
                    </h3>
                    <p class="text-sm text-stone-600">Tanggal Pesan: ${orderDate}</p>
                    <p class="text-sm text-stone-600">Pelanggan: ${data.customer_name || 'Tidak diketahui'}</p>
                </div>
                <div class="text-right space-y-1">
                    <p class="text-lg font-semibold text-gray-700">
                        Total:
                        <span class="text-2xl font-extrabold text-amber-700">
                            Rp ${(data.total || 0).toLocaleString('id-ID')}
                        </span>
                    </p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                </div>
            </div>

            <h4 class="text-lg font-semibold text-gray-800 mb-3">Detail Item:</h4>
            <div class="space-y-4">
                ${itemsHTML}
            </div>

            <div class="mt-4 text-right">
                <a href="/admin/orders/${data.order_id}" class="inline-block text-sm text-blue-600 hover:underline">
                    Lihat detail
                </a>
            </div>
        </div>
    `;
    
    ordersContainer.insertAdjacentHTML('afterbegin', newOrderHTML);
    
    // Remove highlight after 5 seconds
    setTimeout(() => {
        const newOrder = document.getElementById(`order-${data.order_id}`);
        if (newOrder) {
            newOrder.classList.remove('bg-yellow-50', 'border-yellow-300', 'animate-pulse');
            newOrder.classList.add('bg-stone-50', 'border-stone-200');
            const newLabel = newOrder.querySelector('.text-red-500');
            if (newLabel) newLabel.remove();
        }
    }, 5000);
}

function updateStatistics() {
    // Refresh the page or update specific counters if you have them
    console.log('New order received - statistics updated');
}

// Fungsi untuk menampilkan notifikasi
function showNotification(message) {
    const notificationArea = document.getElementById('notification-area');
    const notificationText = document.getElementById('notification-text');
    
    if (notificationArea && notificationText) {
        notificationText.textContent = message;
        notificationArea.classList.remove('hidden');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification();
        }, 5000);
    }
}

function createLiveIndicator() {
    const indicator = document.createElement('div');
    indicator.id = 'live-indicator';
    indicator.className = 'fixed top-4 left-4 w-4 h-4 bg-green-500 rounded-full z-50';
    indicator.title = 'Live Connection Active';
    document.body.appendChild(indicator);
    return indicator;
}

function flashLiveIndicator() {
    // Create a temporary indicator if it doesn't exist
    const indicator = document.getElementById('live-indicator') || createLiveIndicator();
    if (indicator) {
        indicator.classList.add('bg-green-400', 'animate-bounce');
        setTimeout(() => {
            indicator.classList.remove('bg-green-400', 'animate-bounce');
        }, 2000);
    }
}

function hideNotification() {
    const notificationArea = document.getElementById('notification-area');
    if (notificationArea) {
        notificationArea.classList.add('hidden');
    }
}

// Update event listener untuk menampilkan notifikasi yang lebih informatif
channel.bind('new-order', function(data) {
    console.log('NEW ORDER RECEIVED:', data);
    
    // Update statistics
    updateStatistics();
    
    // Add new order to table dengan format lengkap
    addNewOrderToTable(data);

    // Create live indicator
    // createLiveIndicator();
    
    // Show notification dengan detail pesanan
    const itemCount = data.items ? data.items.length : 0;
    const notificationMessage = `Pesanan baru masuk! Order #${data.order_id} dari ${data.customer_name} - ${itemCount} item - Total: Rp ${(data.total || 0).toLocaleString('id-ID')}`;
    showNotification(notificationMessage);
    
    // Flash the live indicator
    // flashLiveIndicator();
});

        // Connection status
        pusher.connection.bind('connected', function() {
            console.log('WebSocket connected');
        });

        pusher.connection.bind('disconnected', function() {
            console.log('WebSocket disconnected');
        });
    </script>
@endpush
</x-app-layout>
