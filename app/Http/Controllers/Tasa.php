<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Tasa extends Controller
{
    public function consultar_tasa(){
        $url = $_ENV["GRANCACIQUE_API"] . "ventas/tasa";
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json(); // Parse JSON response
                return response()->json($data);
            } else {
                throw new \Exception('API request failed');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }
    
}
