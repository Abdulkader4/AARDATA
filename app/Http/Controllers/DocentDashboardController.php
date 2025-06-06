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

        $docentNumber = $request->input('docent_number');

        // حاول تتصل بـ FastAPI
        $response = Http::get("http://localhost:9000/docenten/{$docentNumber}");

        if ($response->successful()) {
            session()->forget('docent_failed_attempts');
            return redirect()->route('docent.dashboard', ['docentNumber' => $docentNumber]);
        } else {
            $attempts = session('docent_failed_attempts', 0) + 1;
            session(['docent_failed_attempts' => $attempts]);

            if ($attempts >= 3) {
                return redirect()->route('docent.form')->withErrors([
                    'docent_number' => 'Te veel foutieve pogingen. Neem contact met ons op.',
                ]);
            }

            return redirect()->route('docent.form')->withErrors([
                'docent_number' => 'Docentnummer niet gevonden.',
            ]);
        }
    }



    public function index(Request $request)
    {
        $response = Http::get('http://localhost:9000/studenten/');

        if ($response->successful()) {
            $studenten = $response->json();

            $filtered = array_filter($studenten, function ($student) use ($request) {
                if ($request->filled('naam') && stripos($student['naam'], $request->input('naam')) === false) {
                    return false;
                }

                if ($request->filled('klas') && $student['klas'] !== $request->input('klas')) {
                    return false;
                }

                if ($request->filled('aanwezigheid_type') && $request->filled('aanwezigheid')) {
                    $type = $request->input('aanwezigheid_type');
                    $value = (int) $request->input('aanwezigheid');
                    $studentValue = (int) str_replace('%', '', $student['gemiddeld_aanwezigheid']);

                    if (
                        ($type === 'lt' && $studentValue >= $value) ||
                        ($type === 'gt' && $studentValue <= $value) ||
                        ($type === 'eq' && $studentValue != $value)
                    ) {
                        return false;
                    }
                }

                if ($request->filled('status') && strtolower($student['status']) !== strtolower($request->input('status'))) {
                    return false;
                }

                if ($request->filled('van')) {
                    $studentDate = strtotime($student['datum'] ?? '0000-00-00');
                    if ($studentDate < strtotime($request->input('van'))) {
                        return false;
                    }
                }

                if ($request->filled('tot')) {
                    $studentDate = strtotime($student['datum'] ?? '9999-12-31');
                    if ($studentDate > strtotime($request->input('tot'))) {
                        return false;
                    }
                }

                return true;
            });

            return view('docent.index', ['studenten' => $filtered]);
        }

        return response()->json([
            'status' => $response->status(),
            'body' => $response->body(),
            'url' => 'http://localhost:9000/studenten/',
        ], 500);
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
