<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TestStudentController extends Controller
{
    public function index()
    {
        // Verbind met FastAPI op poort 9000
        $response = Http::get('http://localhost:9000/studenten/');

        // Check of request slaagt
        if ($response->successful()) {
            $studenten = $response->json();
            return view('test-studenten', compact('studenten'));
        }

        // ❗ Toon de fout als het mislukt
        return response()->json([
            'status' => $response->status(),
            'body' => $response->body(),
            'url' => 'http://localhost:9000/studenten/',
        ], 500);
    }
}
