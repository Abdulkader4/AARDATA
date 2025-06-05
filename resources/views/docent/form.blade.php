<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Docent Inloggen | AARDATA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-900 text-white min-h-screen flex items-center justify-center px-4">
  <div class="bg-white text-black p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-md">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center text-blue-800">Docent Dashboard</h1>

    <!-- Back to Home Button -->
    <form action="{{ url('Welkome') }}" method="GET" class="mb-4 text-center">
      <button type="submit"
        class="text-xs sm:text-sm bg-white text-blue-800 font-medium px-4 py-2 rounded-full shadow hover:bg-gray-100 transition">
        ← Terug naar Home
      </button>
    </form>

    <!-- Login Form -->
    <form action="{{ route('docent.redirect') }}" method="POST" class="space-y-4">
      @csrf
      <label for="docent_number" class="block text-sm sm:text-base font-medium">Wat is uw docentnummer?</label>
      <input type="number" id="docent_number" name="docent_number"
        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
        required>
      <button type="submit"
        class="w-full bg-yellow-400 text-black py-2 rounded hover:bg-yellow-300 transition font-semibold">
        Dashboard Bekijken
      </button>
    </form>
  </div>
</body>

</html>
