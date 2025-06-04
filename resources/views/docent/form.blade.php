<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Docent Inloggen | AARDATA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-900 text-white flex items-center justify-center min-h-screen">
  <div class="bg-white text-black p-6 rounded-xl shadow-xl w-full max-w-md">
    <h1 class="text-xl font-bold mb-4 text-center text-blue-800">Docent Dashboard</h1>

<form action="{{ url('Welkome') }}" method="GET" class="mb-4">
            <button type="submit" class="ml-1 text-xs sm:text-sm bg-white text-blue-800 font-medium px-3 py-1.5 rounded-full shadow hover:bg-gray-100 transition">
                ← Terug naar Home
            </button>
        </form>
        
    <form action="{{ route('docent.redirect') }}" method="POST" class="space-y-4">
      @csrf
      <label for="docent_number" class="block text-sm">Wat is uw docentnummer?</label>
      <input type="number" id="docent_number" name="docent_number" class="w-full border px-3 py-2 rounded" required>
      <button type="submit" class="w-full bg-yellow-400 text-black py-2 rounded hover:bg-yellow-300">Dashboard Bekijken</button>
    </form>
  </div>
</body>
</html>
