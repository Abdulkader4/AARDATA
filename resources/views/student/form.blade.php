<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Student Login | AARDATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-blue-900 text-white flex items-center justify-center">
    <div class="bg-white text-black p-6 rounded-xl shadow-xl w-full max-w-md">
        <h1 class="text-xl font-bold mb-4 text-center text-blue-800">Student Dashboard</h1>

        <form action="{{ url('Welkome') }}" method="GET" class="mb-4">
            <button type="submit" class="ml-1 text-xs sm:text-sm bg-white text-blue-800 font-medium px-3 py-1.5 rounded-full shadow hover:bg-gray-100 transition">
                ← Terug naar Home
            </button>
        </form>

        <form action="{{ route('student.redirect') }}" method="POST" class="space-y-4">
            @csrf
            <label for="student_number" class="block text-sm">Voer je studentnummer in:</label>
            <input type="number" id="student_number" name="student_number" class="w-full border px-3 py-2 rounded" required>
            <button type="submit" class="w-full bg-yellow-400 text-black py-2 rounded hover:bg-yellow-300">Bekijk Dashboard</button>
        </form>
    </div>
</body>
</html>
