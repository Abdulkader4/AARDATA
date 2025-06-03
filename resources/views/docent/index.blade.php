<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Docent Dashboard - AARDATA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(to bottom, #1d3557 0%, #457b9d 100%);
      font-family: 'Segoe UI', sans-serif;
    }
    input, select {
      color: #1d3557;
    }
  </style>
</head>
<body class="text-white min-h-screen">

  <!-- Navbar -->
  <nav class="w-full h-20 bg-[#1d3557] px-6 flex items-center justify-between shadow z-50">
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/99ce1e91-3b73-46a7-9c85-43e5465fd82f.png') }}" class="h-14 md:h-20 lg:h-24" alt="AARDATA Logo">
    </div>    <div class="flex gap-6 text-white text-sm">
      <a href="#" class="hover:text-yellow-300">Student Zoeken</a>
      <a href="#" class="hover:text-yellow-300">Student overzicht</a>
      <a href="#" class="hover:text-yellow-300">Klas overzicht</a>
      <a href="#" class="hover:text-yellow-300">Setting</a>
      <a href="#" class="hover:text-yellow-300">Mijn Profile</a>
    </div>
  </nav>

  <!-- Content Container -->
  <div class="min-h-[calc(100vh-5rem)] flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-6xl space-y-10">

      <!-- Filters -->
      <div class="bg-white text-black p-6 rounded-xl shadow-xl">
        <div class="flex flex-wrap gap-4 items-center justify-center">
          <input type="text" placeholder="Student Zoeken..." class="border rounded px-4 py-2 w-64 shadow">
          <select class="border rounded px-4 py-2 shadow">
            <option>Klas</option>
            <option>SDX1</option>
            <option>SDX2</option>
            <option>SDX3</option>
          </select>
          <select class="border rounded px-4 py-2 shadow">
            <option>Minder dan 33%</option>
            <option>Minder dan 50%</option>
          </select>
          <input type="date" class="border rounded px-4 py-2 shadow">
          <input type="date" class="border rounded px-4 py-2 shadow">
          <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow-md">Filteren</button>
        </div>
      </div>

      <!-- Student Table -->
      <div class="bg-white text-black rounded-xl shadow-xl overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-[#1d3557] text-white">
            <tr>
              <th class="px-6 py-3 text-sm font-semibold">Student</th>
              <th class="px-6 py-3 text-sm font-semibold">Klas</th>
              <th class="px-6 py-3 text-sm font-semibold">Gemiddeld</th>
              <th class="px-6 py-3 text-sm font-semibold text-center">Actie</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Peter</td>
              <td class="px-6 py-4">SDX1</td>
              <td class="px-6 py-4">60%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Jeroen</td>
              <td class="px-6 py-4">SDX1</td>
              <td class="px-6 py-4">93%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Mohammad</td>
              <td class="px-6 py-4">SDX3</td>
              <td class="px-6 py-4">0%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Abdul</td>
              <td class="px-6 py-4">SDX4</td>
              <td class="px-6 py-4">100%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Mama</td>
              <td class="px-6 py-4">SDX4</td>
              <td class="px-6 py-4">99%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">Papa</td>
              <td class="px-6 py-4">SDX2</td>
              <td class="px-6 py-4">21%</td>
              <td class="px-6 py-4 text-center"><i class="fa fa-eye" style="font-size:28px; color:rgb(255, 98, 0);"></i></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>

</body>
</html>
