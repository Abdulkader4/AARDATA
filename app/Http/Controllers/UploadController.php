<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function show()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        // Opslaan in storage/app/uploads
        $path = $request->file('file')->store('uploads');

        return back()->with('success', 'Bestand succesvol geüpload: ' . $path);
    }
}
