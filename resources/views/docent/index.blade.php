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

  <!-- Navbar -->
  <nav
    class="w-full px-4 py-4 flex items-center justify-between fixed top-0 left-0 z-50 bg-[#1d3557] bg-opacity-90 backdrop-blur">
    <div class="flex items-center gap-3">
      {{-- <img src="{{ asset('images/99ce1e91-3b73-46a7-9c85-43e5465fd82f.png') }}" class="h-10 md:h-16"
      alt="AARDATA Logo" /> --}}
      <span class="text-xl font-bold text-yellow-400 hidden sm:inline">AARDATA</span>
    </div>
    <!-- Burger Menu -->
    <div class="md:hidden">
      <button id="burgerBtn" class="text-white focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
      </button>
    </div>
    <!-- Desktop Links -->
    <div class="hidden md:flex gap-6 text-sm">
      {{-- <a href="{{ route('upload.show') }}" class="hover:text-yellow-300">Bestand uploaden</a> --}}

    </div>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-full bg-[#1d3557] p-4 z-40 shadow-md">
    <a href="{{ route('docent.form') }}"
      class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Docentomgeving</a>
    <a href=""
      class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Studentstatistieken</a>
  </div>

  <!-- Content Container -->
  <div class="min-h-[calc(100vh-5rem)] flex items-center justify-center px-2 sm:px-4 py-10 pt-32">
    <div class=" w-full max-w-8xl space-y-10">




      <form method="GET" action="{{ route('docent.dashboard') }}">
        <div class="bg-white text-black p-4 sm:p-6 rounded-xl shadow-xl">
          <div class="flex flex-col sm:flex-wrap sm:flex-row gap-4 sm:gap-6 items-center justify-center">

            <input type="text" name="naam" placeholder="Student Zoeken..." value="{{ request('naam') }}"
              class="border rounded px-4 py-2 w-full sm:w-64 shadow">

            <select name="klas" class="border rounded px-4 py-2 w-full sm:w-40 shadow">
              <option value="">Klas</option>
              <option value="SDX1" {{ request('klas') == 'SDX1' ? 'selected' : '' }}>SDX1</option>
              <option value="SDX2" {{ request('klas') == 'SDX2' ? 'selected' : '' }}>SDX2</option>
              <option value="SDX3" {{ request('klas') == 'SDX3' ? 'selected' : '' }}>SDX3</option>
            </select>

            {{-- aanwezigheid --}}
            <div class="flex flex-col sm:flex-row items-center gap-2">
              <select name="aanwezigheid_type" class="border rounded px-4 py-2 w-full sm:w-40 shadow">
                <option value="">Filtertype</option>
                <option value="lt" {{ request('aanwezigheid_type') == 'lt' ? 'selected' : '' }}>Minder dan</option>
                <option value="gt" {{ request('aanwezigheid_type') == 'gt' ? 'selected' : '' }}>Meer dan</option>
                <option value="eq" {{ request('aanwezigheid_type') == 'eq' ? 'selected' : '' }}>Gelijk aan</option>
              </select>

              <input type="number" name="aanwezigheid" min="0" max="100"
                value="{{ request('aanwezigheid') }}"
                placeholder="Bijv. 20"
                class="border rounded px-4 py-2 w-full sm:w-28 shadow">
            </div>

            <select name="status" class="border rounded px-4 py-2 w-full sm:w-48 shadow">
              <option value="">Status</option>
              <option value="bezig" {{ request('status') == 'bezig' ? 'selected' : '' }}>Bezig</option>
              <option value="gestopt" {{ request('status') == 'gestopt' ? 'selected' : '' }}>Gestopt</option>
              <option value="geslaagd" {{ request('status') == 'geslaagd' ? 'selected' : '' }}>Geslaagd</option>
            </select>

            <input type="date" name="van" value="{{ request('van') }}" class="border rounded px-4 py-2 w-full sm:w-40 shadow">
            <input type="date" name="tot" value="{{ request('tot') }}" class="border rounded px-4 py-2 w-full sm:w-40 shadow">

            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
              <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow-md w-full sm:w-auto">
                Filteren
              </button>

              <a href="{{ route('upload.show') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow-md w-full sm:w-auto text-center transition">
                Upload Bestand
              </a>
            </div>
          </div>
        </div>
      </form>
      <!-- Table -->
      <div class="bg-white text-black rounded-xl shadow-xl overflow-x-auto">
        <table class="w-full min-w-[600px] text-left">
          <thead class="bg-[#1d3557] text-white">
            <tr>
              <th class="px-4 py-3 text-sm font-semibold text-center">Student</th>
              <th class="px-4 py-3 text-sm font-semibold text-center">Klas</th>
              <th class="px-4 py-3 text-sm font-semibold text-center">Gemiddeld</th>
              <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
              <th class="px-4 py-3 text-sm font-semibold text-center">Actie</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 text-center">
            @foreach ($studenten as $student)
            <tr>
              <td>{{ $student['naam'] }}</td>
              <td>{{ $student['klas'] }}</td>
              <td>{{ $student['gemiddeld_aanwezigheid'] }}</td>
              <td>{{ $student['status'] }}</td>
              <td class="px-4 py-3">
                <a href="{{ route('student.show', $student['id']) }}"
                  class="text-blue-600 hover:text-blue-800 font-semibold text-amber-50white px-5 py-2 rounded shadow-md w-full sm:w-auto">Bekijk</a>
              </td>
            </tr>


            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Scripts -->
  <script>
    document.getElementById('burgerBtn').addEventListener('click', function() {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    });
  </script>

</body>

</html>
