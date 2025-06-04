<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentOverviewController extends Controller
{
    // Overzicht van alle studenten
    public function index()
    {
        $students = [
            ['nummer' => 's1001', 'naam' => 'Layla Karim', 'percentage' => 92],
            ['nummer' => 's1002', 'naam' => 'Yasmin Khan', 'percentage' => 85],
            ['nummer' => 's1003', 'naam' => 'Fatima Noor', 'percentage' => 78],
        ];

        return view('student.overzicht', compact('students'));
    }

    // Individuele studentendashboard
    public function show($nummer)
    {
        $students = [
            's1001' => ['naam' => 'Layla Karim', 'percentage' => 92, 'studentNumber' => 's1001'],
            's1002' => ['naam' => 'Yasmin Khan', 'percentage' => 85, 'studentNumber' => 's1002'],
            's1003' => ['naam' => 'Fatima Noor', 'percentage' => 78, 'studentNumber' => 's1003'],
        ];

        $attendances = [
            ['week' => 'Week 10', 'year' => '2024', 'minutes' => 1200, 'percentage' => 90],
            ['week' => 'Week 11', 'year' => '2024', 'minutes' => 1440, 'percentage' => 100],
            ['week' => 'Week 12', 'year' => '2024', 'minutes' => 720, 'percentage' => 75],
        ];

        if (!isset($students[$nummer])) {
            abort(404);
        }

        $student = $students[$nummer];

        return view('student.dashboard', [
            'loggedInStudentName' => $student['naam'],
            'studentNumber' => $student['studentNumber'],
            'percentage' => $student['percentage'],
            'attendances' => $attendances,
            'from' => null,
            'to' => null,
            'week' => null,
        ]);
    }
}
