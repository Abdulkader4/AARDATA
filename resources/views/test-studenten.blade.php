<!DOCTYPE html>
<html>

<head>
    <title>Test Studenten</title>
</head>

<body>
    <h1>Studenten</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Studentnummer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studenten as $student)
            <tr>
                <td>{{ $student['naam'] }}</td>
                <td>{{ $student['email'] }}</td>
                <td>{{ $student['studentnummer'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>