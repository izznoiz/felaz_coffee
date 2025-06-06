<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <script src="//unpkg.com/alpinejs" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')


    <!-- Floating Chatbot Component -->
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <button @click="open = !open"
            class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-full shadow-lg focus:outline-none transition">
            💬
        </button>

        <!-- Chat Widget -->
        <div x-show="open" x-cloak x-transition
            class="mt-2 w-80 h-96 bg-white shadow-xl rounded-xl border border-gray-300 flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="bg-amber-700 text-white px-4 py-2 flex justify-between items-center">
                <span class="font-semibold">Chatbot Kopi</span>
                <button @click="open = false" class="hover:text-gray-200">✕</button>
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto text-sm space-y-2 bg-stone-50">
                <div class="text-center text-gray-400 text-xs">Chat dimulai...</div>
            </div>

            <!-- Input -->
            <div class="border-t p-2">
                <form id="chat-form" class="flex gap-2">
                    <input type="text" id="chat-input" class="flex-1 px-3 py-2 border rounded focus:outline-none"
                        placeholder="Ketik pesan..." required>
                    <button type="submit"
                        class="bg-amber-700 text-white px-3 py-2 rounded hover:bg-amber-800">Kirim</button>
                </form>
            </div>
        </div>
    </div>


    {{-- Di akhir file Blade --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatForm = document.querySelector("#chat-form");
            const input = document.querySelector("#chat-input");
            const chatBox = document.querySelector("#chat-messages");

            chatForm.addEventListener("submit", async function (e) {
                e.preventDefault();
                const msg = input.value.trim();
                if (!msg) return;

                // Tambahkan pesan pengguna
                chatBox.innerHTML += `
                <div class="text-right">
                    <div class="inline-block bg-amber-100 text-gray-800 px-3 py-2 rounded-lg shadow-sm mb-1 max-w-xs">
                        ${msg}
                    </div>
                </div>
            `;
                input.value = "";
                chatBox.scrollTop = chatBox.scrollHeight;

                // Tambahkan animasi loading balasan
                const loader = document.createElement("div");
                loader.className = "text-left animate-pulse text-sm text-gray-500";
                loader.innerHTML = `<div class="inline-block bg-gray-200 px-3 py-2 rounded-lg shadow-sm max-w-xs">Mengetik...</div>`;
                chatBox.appendChild(loader);
                chatBox.scrollTop = chatBox.scrollHeight;

                try {
                    const res = await fetch("https://9297-34-31-213-105.ngrok-free.app/chat", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content,
                        },
                        body: JSON.stringify({ question: msg })
                    });


                    const data = await res.json();
                    const reply = data.response ?? "Maaf, terjadi kesalahan.";

                    loader.remove(); // hapus animasi "Mengetik..."

                    chatBox.innerHTML += `
                    <div class="text-left">
                        <div class="inline-block bg-gray-100 text-amber-800 px-3 py-2 rounded-lg shadow-sm mb-1 max-w-xs">
                            ${reply}
                        </div>
                    </div>
                `;
                    chatBox.scrollTop = chatBox.scrollHeight;
                } catch (error) {
                    loader.remove();

                    chatBox.innerHTML += `
                    <div class="text-left text-sm text-red-600">
                        Gagal menghubungi chatbot. Coba lagi nanti.
                    </div>
                `;
                }
            });
        });
    </script>

</body>

</html>