<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Help - AARDATA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a2e0f1b7a1.js" crossorigin="anonymous"></script>
  <style>
    body {
      background: linear-gradient(to bottom, #1d3557 0%, #457b9d 100%);
      font-family: 'Segoe UI', sans-serif;
    }
  </style>
</head>
<body class="text-white min-h-screen">

  <!-- Navbar -->
  <nav class="w-full px-4 py-4 flex items-center justify-between fixed top-0 left-0 z-50 bg-[#1d3557] bg-opacity-90 backdrop-blur shadow">
    <div class="text-2xl font-bold text-yellow-400">AARDATA</div>

    <!-- Desktop menu -->
    <div class="hidden md:flex gap-6 text-sm">
      <a href="/" class="hover:text-yellow-300">Home</a>
      <a href="/help" class="hover:text-yellow-300 font-semibold underline">Help</a>
    </div>

    <!-- Burger menu for mobile -->
    <div class="md:hidden p-2 fixed top-4 right-4 z-[9999]">
      <button id="burgerBtn" class="text-white text-lg font-bold"><i class="fas fa-bars text-2xl"></i>
      </button>
    </div>

  </nav>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-full bg-[#1d3557] p-4 z-40 shadow-md">
    <a href="/" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Home</a>
    <a href="/help" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition font-semibold underline">Help</a>
  </div>

  <!-- Content -->
  <div class="max-w-4xl mx-auto px-4 pt-32 pb-10 space-y-10">
    <h1 class="text-3xl font-bold text-center text-white mb-8">Help & Uitleg</h1>

    <div class="bg-white text-[#1d3557] p-6 rounded-xl shadow space-y-4">
      <h2 class="text-xl font-bold">Wat is AARDATA?</h2>
      <p>AARDATA is een slim platform voor digitale registratie van aanwezigheid en statistieken.</p>
    </div>

    <div class="bg-white text-[#1d3557] p-6 rounded-xl shadow space-y-4">
      <h2 class="text-xl font-bold">Wat zie ik in mijn dashboard?</h2>
      <p>Overzicht van studenten met klas, status, aanwezigheidsgemiddelde en een knop voor statistieken.</p>
    </div>

    <div class="bg-white text-[#1d3557] p-6 rounded-xl shadow space-y-4">
      <h2 class="text-xl font-bold">Hoe filter ik mijn aanwezigheid?</h2>
      <p>Gebruik filters bovenaan het dashboard. Klik op <span class="text-blue-600 font-semibold">Filteren</span>.</p>
    </div>

    <div class="bg-white text-[#1d3557] p-6 rounded-xl shadow space-y-4">
      <h2 class="text-xl font-bold">Wat betreft de kleuren of grafieken?</h2>
      <ul class="list-disc pl-5">
        <li><span class="text-green-600 font-semibold">Groen</span>: Geslaagd / 100% aanwezig</li>
        <li><span class="text-yellow-500 font-semibold">Geel</span>: Waarschuwing (onder 50%)</li>
        <li><span class="text-red-600 font-semibold">Rood</span>: Onvoldoende aanwezigheid</li>
      </ul>
    </div>
  </div>

  <!-- Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const burgerBtn = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');

      burgerBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    });
  </script>
</body>
</html>
