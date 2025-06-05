<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Docent Dashboard - AARDATA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(to bottom, #1d3557 0%, #457b9d 100%);
      font-family: 'Segoe UI', sans-serif;
    }

    input,
    select {
      color: #1d3557;
    }
  </style>
</head>

<body class="text-white min-h-screen">

  <!-- Navbar met Uploadknop rechtsboven -->
  <nav class="w-full px-4 py-4 flex items-center justify-between fixed top-0 left-0 right-0 z-50 bg-[#1d3557] bg-opacity-90 backdrop-blur">
    <div class="flex items-center gap-3">
      <span class="text-xl font-bold text-yellow-400 hidden sm:inline">AARDATA</span>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('upload.show') }}" class="hidden md:inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow-md text-sm transition">
        <i class="fas fa-upload mr-2"></i> Upload Bestand
      </a>
      <button id="burgerBtn" class="text-white md:hidden focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-full bg-[#1d3557] p-4 z-40 shadow-md">
    <a href="{{ route('docent.form') }}" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Docentomgeving</a>
    <a href="#" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Studentstatistieken</a>
    <a href="{{ route('upload.show') }}" class="block py-2 px-4 mt-2 bg-green-600 text-white text-center rounded shadow hover:bg-green-700">
      <i class="fas fa-upload mr-1"></i> Upload Bestand
    </a>
  </div>

  <!-- Filtersectie compact en bovenin -->
  <div class="mt-28 px-4">
    <div class="bg-white text-[#1d3557] p-4 rounded-xl shadow-xl overflow-x-auto">
      <div class="flex flex-wrap items-center gap-4 min-w-full">
        <div class="relative">
          <input type="text" placeholder="Zoek student..." class="border rounded pl-10 pr-4 py-2 w-48 shadow focus:ring-blue-400 focus:outline-none">
          <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <select class="border rounded px-4 py-2 w-40 shadow focus:ring-blue-400 focus:outline-none">
          <option>Klas</option>
          <option>SDX1</option>
          <option>SDX2</option>
          <option>SDX3</option>
        </select>
        <select class="border rounded px-4 py-2 w-52 shadow focus:ring-blue-400 focus:outline-none">
          <option>Aanwezigheid < 33%</option>
          <option>Aanwezigheid < 50%</option>
        </select>
        <select class="border rounded px-4 py-2 w-40 shadow focus:ring-blue-400 focus:outline-none">
          <option>Status</option>
          <option>Bezig</option>
          <option>Gestopt</option>
        </select>
        <input type="date" class="border rounded px-4 py-2 w-40 shadow focus:ring-blue-400 focus:outline-none">
        <input type="date" class="border rounded px-4 py-2 w-40 shadow focus:ring-blue-400 focus:outline-none">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow-md transition">
          <i class="fas fa-filter mr-2"></i> Filteren
        </button>
      </div>
    </div>
  </div>

  <!-- Tabel -->
  <div class="mt-6 px-4">
    <div class="bg-white text-black rounded-xl shadow-xl overflow-x-auto">
      <table class="w-full min-w-[600px] text-left">
        <thead class="bg-[#1d3557] text-white">
          <tr>
            <th class="px-4 py-3 text-sm font-semibold text-center">Student</th>
            <th class="px-4 py-3 text-sm font-semibold text-center">Klas</th>
            <th class="px-4 py-3 text-sm font-semibold text-center">Aanwezigheid (%)</th>
            <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
            <th class="px-4 py-3 text-sm font-semibold text-center">Actie</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-center">
          @foreach ($studenten as $student)
          <tr class="hover:bg-gray-100">
            <td class="px-4 py-3">{{ $student['naam'] }}</td>
            <td class="px-4 py-3">{{ $student['klas'] }}</td>
            <td class="px-4 py-3">{{ $student['gemiddeld_aanwezigheid'] }}%</td>
            <td class="px-4 py-3">{{ $student['status'] }}</td>
            <td class="px-4 py-3">
              <a href="{{ route('student.show', $student['id']) }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-1.5 rounded shadow text-sm transition">
                Bekijk
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script -->
  <script>
    document.getElementById('burgerBtn').addEventListener('click', function () {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    });
  </script>

</body>

</html>
