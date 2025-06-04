<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class UploadController extends Controller
{
    public function show()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,ods',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        // Bestandsnaam controle: AAR_2024_W12_bla.xlsx of .ods
        if (!preg_match('/^AAR_\d{4}_W\d{2}.*\.(xlsx|ods)$/', $filename)) {
            return back()->with('error', 'Bestandsnaam voldoet niet aan de vereiste naamgevingsconventie.');
        }

        try {
            // Bestand uitlezen naar een collection
            $data = Excel::toCollection(null, $file)->first();

            if (!$data || $data->isEmpty()) {
                return back()->with('error', 'Bestand bevat geen gegevens.');
            }

            // Controleer kolomkoppen (eerste rij)
            $headers = $data->first()->keys()->toArray();
            $requiredHeaders = ['Jaar', 'Week', 'Rooster', 'Aanwezigheid', 'Studentnr'];

            if ($headers !== $requiredHeaders) {
                return back()->with('error', 'Kolomnamen komen niet overeen met de vereiste structuur.');
            }

            // Filter lege rijen uit
            $validRows = $data->filter(function ($row) {
                return $row->filter()->isNotEmpty();
            });

            // Verwerk de rijen (hier alleen logging; later kun je database-opslag doen)
            foreach ($validRows as $index => $row) {
                try {
                    // Simuleer verwerking of opslaan
                    Log::info("Rij $index verwerkt:", $row->toArray());
                    // TODO: voeg database-insert hier toe, met checks op dubbele week/student
                } catch (\Exception $e) {
                    Log::error("Fout bij rij $index: " . $e->getMessage());
                }
            }

            // Bestand opslaan in storage (optioneel)
            $path = $file->storeAs('uploads', $filename);

            return back()->with('success', 'Bestand succesvol geüpload en gevalideerd.');
        } catch (\Exception $e) {
            Log::error('Fout bij upload: ' . $e->getMessage());
            return back()->with('error', 'Er ging iets mis tijdens het verwerken van het bestand.');
        }
    }
}
