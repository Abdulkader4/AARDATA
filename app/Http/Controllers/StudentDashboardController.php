<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $loggedInStudentNumber = '123456';
        $loggedInStudentName = 'Abdulkader Mlaies';

        // Dummydata
        $allAttendances = [
            ['week' => 'Week 10', 'year' => '2v24', 'minutes' => 1440, 'percentage' => 94],
            ['week' => 'Week 11', 'year' => '2v24', 'minutes' => 1560, 'percentage' => 100],
            ['week' => 'Week 12', 'year' => '2v24', 'minutes' => 60, 'percentage' => 35],
            ['week' => 'Week 13', 'year' => '2v24', 'minutes' => 720, 'percentage' => 54],
        ];

        // Filters (eventueel uitbreidbaar later)
        $from = $request->input('from');
        $to = $request->input('to');
        $week = $request->input('week');

        // Berekening: gemiddelde aanwezigheid over de zichtbare weken
        $visible = $allAttendances;

        if ($week) {
            $visible = array_filter($visible, fn($row) => str_replace('Week ', '', $row['week']) == $week);
        }

        $totalPercentage = array_sum(array_column($visible, 'percentage'));
        $average = count($visible) ? round($totalPercentage / count($visible)) : 0;

        return view('student.redesign', [
            'loggedInStudentName' => $loggedInStudentName,
            'attendances' => $visible,
            'percentage' => $average,
            'from' => $from,
            'to' => $to,
            'week' => $week
        ]);
    }
}
