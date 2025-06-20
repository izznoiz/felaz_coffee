<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Felaz Coffee') }}</title>

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
            class="group bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-amber-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:scale-110"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </button>

        <!-- Chat Widget -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2" x-cloak
            class="mb-4 w-96 h-[28rem] bg-white shadow-2xl rounded-2xl border border-gray-200 flex flex-col overflow-hidden backdrop-blur-sm">

            <!-- Header -->
            <div
                class="bg-gradient-to-r from-amber-600 to-amber-700 text-white px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <div>
                        <h3 class="font-semibold text-lg">Felaz Chatbot</h3>
                        <p class="text-amber-100 text-xs">Siap membantu Anda</p>
                    </div>
                </div>
                <button @click="open = false" class="hover:bg-amber-800 p-1 rounded transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Messages Container -->
            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gradient-to-b from-gray-50 to-white">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Felaz Coffee Logo"
                                class="h-14 w-14 object-cover rounded-full shadow-md">
                        </div>
                        <p class="text-gray-500 text-sm">Mulai percakapan dengan kami!</p>
                        <p class="text-gray-400 text-xs mt-1">Tanyakan tentang kopi favorit Anda</p>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="border-t border-gray-200 bg-gray-50 p-4">
                <form id="chat-form" class="flex gap-3">
                    <input type="text" id="chat-input"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-white"
                        placeholder="Ketik pesan Anda..." required>
                    <button type="submit"
                        class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatForm = document.querySelector("#chat-form");
            const input = document.querySelector("#chat-input");
            const chatBox = document.querySelector("#chat-messages");
            let isFirstMessage = true;

            // Function to clear welcome message
            function clearWelcomeMessage() {
                if (isFirstMessage) {
                    chatBox.innerHTML = '<div class="space-y-3"></div>';
                    isFirstMessage = false;
                }
            }

            //function click link
            function linkify(text) {
                // Regular expression to match URLs
                const urlRegex = /(https?:\/\/[^\s<>"{}|\\^`[\]]+)/gi;

                return text.replace(urlRegex, function (url) {
                    // Clean the URL (remove trailing punctuation if any)
                    const cleanUrl = url.replace(/[.,;:!?]+$/, '');
                    const trailingPunc = url.slice(cleanUrl.length);

                    return `<a href="${cleanUrl}" class="text-amber-600 hover:text-amber-800 underline font-medium transition-colors duration-200">${cleanUrl}</a>${trailingPunc}`;
                });
            }

            // Function to add user message
            function addUserMessage(message) {
                const messageDiv = document.createElement("div");
                messageDiv.className = "flex justify-end mb-3";
                messageDiv.innerHTML = `
            <div class="max-w-xs lg:max-w-md">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-3 rounded-2xl rounded-br-md shadow-md">
                    <p class="text-sm">${message}</p>
                </div>
                <p class="text-xs text-gray-400 mt-1 text-right">Baru saja</p>
            </div>
        `;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // Function to add bot message
            function addBotMessage(message) {
                const messageDiv = document.createElement("div");
                messageDiv.className = "flex justify-start mb-3";

                const messageWithLinks = linkify(message);

                messageDiv.innerHTML = `
            <div class="max-w-xs lg:max-w-md">
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 bg-amber-600 rounded-full"></div>
                    </div>
                    <div>
                        <div class="bg-white border border-gray-200 px-4 py-3 rounded-2xl rounded-bl-md shadow-md">
                            <p class="text-sm text-gray-800">${messageWithLinks}</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-2">Baru saja</p>
                    </div>
                </div>
            </div>
        `;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // Function to show typing indicator
            function showTypingIndicator() {
                const typingDiv = document.createElement("div");
                typingDiv.id = "typing-indicator";
                typingDiv.className = "flex justify-start mb-3";
                typingDiv.innerHTML = `
            <div class="flex items-start space-x-2">
                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <div class="w-3 h-3 bg-amber-600 rounded-full animate-pulse"></div>
                </div>
                <div class="bg-white border border-gray-200 px-4 py-3 rounded-2xl rounded-bl-md shadow-md">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    </div>
                </div>
            </div>
        `;
                chatBox.appendChild(typingDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // Function to remove typing indicator
            function removeTypingIndicator() {
                const typingIndicator = document.querySelector("#typing-indicator");
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }

            // Handle form submission
            chatForm.addEventListener("submit", async function (e) {
                e.preventDefault();
                const message = input.value.trim();
                if (!message) return;

                clearWelcomeMessage();
                addUserMessage(message);
                input.value = "";

                showTypingIndicator();

                try {
                    const response = await fetch("https://d76f-35-243-193-38.ngrok-free.app/chat", {

                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content,
                        },
                        body: JSON.stringify({ question: message })
                    });

                    const data = await response.json();
                    console.log(data);
                    const reply = data.response || "Maaf, terjadi kesalahan dalam memproses permintaan Anda.";

                    removeTypingIndicator();
                    addBotMessage(reply);

                } catch (error) {
                    removeTypingIndicator();
                    addBotMessage("Maaf, tidak dapat terhubung ke server. Silakan coba lagi nanti.");
                    console.error("Chat error:", error);
                }
            });

            // Auto-focus input when chat opens
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        const chatWidget = document.querySelector('[x-show="open"]');
                        if (chatWidget && !chatWidget.hasAttribute('x-cloak')) {
                            setTimeout(() => input.focus(), 100);
                        }
                    }
                });
            });

            observer.observe(document.querySelector('[x-show="open"]'), { attributes: true });
        });
    </script>

</body>

</html>