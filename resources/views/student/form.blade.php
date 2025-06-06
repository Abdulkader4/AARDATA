<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login | AARDATA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-blue-900 text-white flex items-center justify-center px-4">
  <div class="bg-white text-black p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-md">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center text-blue-800">Student Dashboard</h1>

    <!-- Back to Home -->
    <form action="{{ url('Welkome') }}" method="GET" class="mb-4 text-center">
      <button type="submit"
        class="text-xs sm:text-sm bg-white text-blue-800 font-medium px-4 py-2 rounded-full shadow hover:bg-gray-100 transition">
        ← Terug naar Home
      </button>
    </form>

    <form action="{{ route('student.redirect') }}" method="POST" class="space-y-4">
      @csrf

      <label for="student_number" class="block text-sm sm:text-base font-medium">Voer je studentnummer in:</label>

      <input type="number" id="student_number" name="student_number"
        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
        required>

      @error('student_number')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
      @enderror

      <button type="submit"
        class="w-full bg-yellow-400 text-black py-2 rounded hover:bg-yellow-300 transition font-semibold">
        Bekijk Dashboard
      </button>
    </form>

  </div>
</body>
</html>
