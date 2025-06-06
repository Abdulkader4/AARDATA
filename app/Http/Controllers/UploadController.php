<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;


class UploadController extends Controller
{
    public function show()
    {
        $response = Http::get('http://localhost:9000/uploads'); // FastAPI endpoint

        if ($response->successful()) {
            $files = $response->json();
        } else {
            $files = [];
        }

        return view('upload', compact('files'));
    }

    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,ods',
    ]);

    try {
        $response = Http::attach(
            'file', file_get_contents($request->file('file')), $request->file('file')->getClientOriginalName()
        )->post('http://localhost:9000/upload');

        if ($response->successful()) {
            return back()->with('success', 'Bestand succesvol geüpload.');
        } else {
            return back()->with('error', 'Upload mislukt: ' . $response->body());
        }
    } catch (\Exception $e) {
        return back()->with('error', 'Er is een fout opgetreden tijdens upload: ' . $e->getMessage());
    }
}

public function fetchUploads()
{
    $response = Http::get('http://localhost:9000/uploads');

    if ($response->successful()) {
        $files = $response->json();
        return view('upload_list', compact('files'));
    } else {
        return view('upload_list')->with('error', 'Fout bij ophalen van bestanden.');
    }
}
}
