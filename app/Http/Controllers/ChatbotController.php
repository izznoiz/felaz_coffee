<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message');

        // Contoh balasan statis - nanti bisa ganti dengan LLM atau LangChain
        $response = match (strtolower($message)) {
            'hai', 'halo' => 'Halo juga! Ada yang bisa saya bantu?',
            'menu' => 'Kami punya kopi hitam, kopi susu, dan cappuccino.',
            'buka jam berapa' => 'Kami buka setiap hari dari jam 08:00 sampai 20:00.',
            default => "Maaf, saya belum mengerti: \"$message\". Silakan coba tanya yang lain ya 😊",
        };

        return response()->json(['reply' => $response]);
    }
}
