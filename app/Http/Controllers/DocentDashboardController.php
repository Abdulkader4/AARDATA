<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $loggedInDocentName = 'Docent ' . $docentNumber;

        return view('docent.index', [
            'loggedInDocentName' => $loggedInDocentName
        ]);
    }
}
