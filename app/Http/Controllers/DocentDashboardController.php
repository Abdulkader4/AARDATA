<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DocentDashboardController extends Controller
{
    public function showForm()
    {
        return view('docent.form');
    }

    public function redirectToDashboard(Request $request)
    {
        $request->validate([
            'docent_number' => 'required|numeric'
        ]);

        return redirect()->route('docent.dashboard', ['docentNumber' => $request->docent_number]);
    }


    
    public function index(Request $request, $docentNumber)
    {
        // Verbind met FastAPI op poort 9000
        $response = Http::get('http://localhost:9000/studenten/');

        // Check of request slaagt
        if ($response->successful()) {
            $studenten = $response->json();
            return view('docent.index', compact('studenten'));
        }

        // ❗ Toon de fout als het mislukt
        return response()->json([
            'status' => $response->status(),
            'body' => $response->body(),
            'url' => 'http://localhost:9000/studenten/',
        ], 500);

        $loggedInDocentName = 'Docent ' . $docentNumber;

        return view('docent.index', [
            'loggedInDocentName' => $loggedInDocentName
        ]);
    }

    public function showstudent($id)
    {
        // Verbind met FastAPI op poort 9000
        $response = Http::get('http://localhost:9000/studenten/' . $id);

        // Check of request slaagt
        if ($response->successful()) {
            $student = $response->json();
            return view('docent.showstudent', compact('student'));
        }

        // ❗ Toon de fout als het mislukt
        return response()->json([
            'status' => $response->status(),
            'body' => $response->body(),
            'url' => 'http://localhost:9000/studenten/' . $id,
        ], 500);
    }

    
}