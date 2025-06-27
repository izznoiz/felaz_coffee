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

    {{-- <audio id="notification-sound" preload="auto">
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

        // Subscribe to admin-orders channel
        const channel = pusher.subscribe('admin-orders');

        // Listen for new-order event
        channel.bind('new-order', function(data) {
            console.log('New order received:', data);

            // Update statistics
            updateStatistics();
            
            // Add new order to table
            addNewOrderToTable(data);
            
            // Show notification
            showNotification(`${data.message} - Order #${data.order_id} dari ${data.customer_name}`);
            
            // Play notification sound
            // playNotificationSound();
            
            // Flash the live indicator
            flashLiveIndicator();
        });

        function updateStatistics() {
            // Update total orders counter
            const totalOrdersEl = document.getElementById('total-orders');
            if (totalOrdersEl) {
                const currentTotal = parseInt(totalOrdersEl.textContent) || 0;
                totalOrdersEl.textContent = currentTotal + 1;
            } else {
                console.warn('Total orders element not found');
            }
            
            // Update pending orders counter
            const pendingOrdersEl = document.getElementById('pending-orders');
            if (pendingOrdersEl) {
                const currentPending = parseInt(pendingOrdersEl.textContent) || 0;
                pendingOrdersEl.textContent = currentPending + 1;
            } else {
                console.warn('Pending orders element not found');
            }
        }

        function addNewOrderToTable(data) {
            const tableBody = document.getElementById('orders-table-body');
            
            if (!tableBody) {
                console.warn('Orders table body not found');
                return;
            }
            
            // Create new row HTML
            const newRowHTML = `
                <tr id="order-row-${data.order_id}" class="bg-yellow-50 animate-pulse">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#${data.order_id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${data.customer_name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp ${Number(data.total).toLocaleString('id-ID')}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${data.created_at}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/${data.order_id}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                    </td>
                </tr>
            `;
            
            // Insert at the top of the table
            tableBody.insertAdjacentHTML('afterbegin', newRowHTML);
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                const newRow = document.getElementById(`order-row-${data.order_id}`);
                if (newRow) {
                    newRow.classList.remove('bg-yellow-50', 'animate-pulse');
                }
            }, 3000);
        }

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
            } else {
                console.warn('Notification elements not found');
                // Fallback to browser notification or alert
                alert(message);
            }
        }

        function hideNotification() {
            const notificationArea = document.getElementById('notification-area');
            if (notificationArea) {
                notificationArea.classList.add('hidden');
            }
        }

        // function playNotificationSound() {
        //     const audio = document.getElementById('notification-sound');
        //     if (audio) {
        //         audio.play().catch(e => {
        //             console.log('Could not play notification sound:', e);
        //         });
        //     } else {
        //         console.warn('Notification sound element not found');
        //     }
        // }

        function flashLiveIndicator() {
            const indicator = document.getElementById('live-indicator');
            if (indicator) {
                indicator.classList.add('bg-green-200');
                setTimeout(() => {
                    indicator.classList.remove('bg-green-200');
                }, 1000);
            } else {
                console.warn('Live indicator element not found');
            }
        }

        // Connection status
        pusher.connection.bind('connected', function() {
            console.log('WebSocket connected');
            const indicator = document.getElementById('live-indicator');
            if (indicator) {
                indicator.classList.remove('bg-red-100', 'text-red-800');
                indicator.classList.add('bg-green-100', 'text-green-800');
            }
        });

        pusher.connection.bind('disconnected', function() {
            console.log('WebSocket disconnected');
            const indicator = document.getElementById('live-indicator');
            if (indicator) {
                indicator.classList.remove('bg-green-100', 'text-green-800');
                indicator.classList.add('bg-red-100', 'text-red-800');
            }
        });

        // Debug connection
        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });

        // Debug channel subscription
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to admin-orders channel');
        });

        channel.bind('pusher:subscription_error', function(error) {
            console.error('Subscription error:', error);
        });
    </script>
@endpush
</x-app-layout>