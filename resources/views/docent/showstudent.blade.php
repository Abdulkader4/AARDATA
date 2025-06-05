<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Student Details</h1>
    <p><strong>Name:</strong> {{ $student['naam'] }}</p>
    <p><strong>Email:</strong> {{ $student['email'] }}</p>
    <p><strong>Student Number:</strong> {{ $student['studentnummer'] }}</p>
    <p><strong>Class:</strong> {{ $student['klas'] }}</p>
    <p><strong>Average Attendance:</strong> {{ $student['gemiddeld_aanwezigheid'] }}%</p>
    <p><strong>Status:</strong> {{ $student['status'] }}</p>
</body>
</html>