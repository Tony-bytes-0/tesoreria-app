<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CuentasBancariasController extends Controller
{
    public function consultar_cuentas_bancarias_naviarca()
    {
        $url = $_ENV["NAVIARCA_API"]."cuentas";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json(); // Parse JSON response
                return response()->json($data);
            } else {
                throw new \Exception('API request failed');
            }
        } catch (\Exception $e) {
            Log::error('Error calling external API: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }

    public function consultar_cuentas_bancarias_gc()
    {
        $url = $_ENV["GRANCACIQUE_API"] . "cuentas";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json(); // Parse JSON response
                return response()->json($data);
            } else {
                throw new \Exception('API request failed');
            }
        } catch (\Exception $e) {
            Log::error('Error calling external API: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }
}
