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
            "reply"=> "Halo! Ada yang bisa saya bantu?",
            'hai', 'halo' => 'Halo juga! Ada yang bisa saya bantu?',
            'menu' => 'Kami punya kopi gula aren, matcha latte, ramen miso juga shoyu, dan rujak cireng.',
            'buka jam berapa' => 'Kami buka setiap hari dari jam 08:00 sampai 20:00.',
            default => "Maaf, saya belum mengerti: \"$message\". Silakan coba tanya yang lain ya 😊",
        };

        return response()->json(['reply' => $response]);
    }
}
