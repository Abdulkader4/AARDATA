<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class StudentDashboardController extends Controller
{
    public function showForm()
    {
        return view('student.form');
    }





    public function redirectToDashboard(Request $request)
    {
        $request->validate([
            'student_number' => 'required|numeric'
        ]);

        $studentNumber = $request->input('student_number');

        $response = Http::get("http://localhost:9000/studenten/{$studentNumber}");

        if ($response->successful()) {
            session()->forget('student_failed_attempts');
            return redirect()->route('student.dashboard', ['studentNumber' => $studentNumber]);
        } else {
            $attempts = session('student_failed_attempts', 0) + 1;
            session(['student_failed_attempts' => $attempts]);

            if ($attempts >= 3) {
                return redirect()->route('student.form')->withErrors([
                    'student_number' => 'Te veel foutieve pogingen. Neem contact met ons op.',
                ]);
            }
            return redirect()->route('student.form')->withErrors([
                'student_number' => 'Studentnummer niet gevonden.',
            ]);
        }
    }





    public function index(Request $request, $studentNumber)
    {
        $loggedInStudentName = 'Student ' . $studentNumber;

        $allAttendances = [
            ['week' => 'Week 10', 'year' => '2v24', 'minutes' => 1440, 'percentage' => 94],
            ['week' => 'Week 11', 'year' => '2v24', 'minutes' => 1560, 'percentage' => 100],
            ['week' => 'Week 12', 'year' => '2v24', 'minutes' => 60, 'percentage' => 35],
            ['week' => 'Week 13', 'year' => '2v24', 'minutes' => 720, 'percentage' => 54],
        ];

        $week = $request->input('week');

        $visible = $week
            ? array_filter($allAttendances, fn($row) => str_replace('Week ', '', $row['week']) == $week)
            : $allAttendances;

        $average = count($visible) ? round(array_sum(array_column($visible, 'percentage')) / count($visible)) : 0;

        return view('student.redesign', [
            'loggedInStudentName' => $loggedInStudentName,
            'studentNumber' => $studentNumber,
            'attendances' => $visible,
            'percentage' => $average,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'week' => $week
        ]);
    }
}
