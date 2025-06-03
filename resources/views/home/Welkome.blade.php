<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Welkom bij AARDATA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      background: linear-gradient(135deg, #1d3557, #457b9d);
      font-family: 'Segoe UI', sans-serif;
    }
  </style>
</head>
<body class="text-white">

  <!-- Navbar -->
  <nav class="w-full px-4 py-3 flex items-center justify-between fixed top-0 left-0 z-50  bg-opacity-90 backdrop-blur">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/99ce1e91-3b73-46a7-9c85-43e5465fd82f.png') }}" class="h-14 md:h-20 lg:h-24" alt="AARDATA Logo">
    </div>

    <!-- Burger Button -->
    <div class="md:hidden">
      <button id="burgerBtn" class="text-white focus:outline-none">
        <i data-lucide="menu" class="w-8 h-8"></i>
      </button>
    </div>

  </nav>

  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-full bg-[#1d3557] p-4 z-40 shadow-md">
    <a href="#" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Docentomgeving</a>
    <a href="#" class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Studentstatistieken</a>
  </div>

  <div class="flex flex-col justify-center items-center min-h-screen text-center px-4 pt-10">
    <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-4 flex items-center gap-2" data-aos="fade-down">
      <i data-lucide="database" class="w-10 h-10 text-yellow-300"></i>
      Welkom bij <span class="text-yellow-300">AARDATA</span>
    </h1>

    <p class="text-base sm:text-lg md:text-xl mb-8 max-w-2xl flex items-center justify-center gap-2" data-aos="fade-up" data-aos-delay="200">
      <i data-lucide="bar-chart-3" class="w-10 h-10 text-white"></i>
      Een slim platform voor digitale registratie van aanwezigheid en statistieken.
    </p>

    <div class="flex flex-col md:flex-row gap-4" data-aos="zoom-in" data-aos-delay="400">
      <a href="#" class="px-6 py-3 bg-yellow-400 text-black font-medium rounded-full shadow-lg hover:bg-yellow-300 transition-all duration-300 flex items-center gap-2">
        <i class="fas fa-chalkboard-teacher text-lg"></i>
        Ga naar Docentomgeving
      </a>
      <a href="#" class="px-6 py-3 bg-white text-blue-800 rounded-full shadow-lg hover:bg-gray-200 transition-all duration-300 flex items-center gap-2">
        <i data-lucide="users" class="w-5 h-5"></i>
        Bekijk Studentstatistieken
      </a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
    lucide.createIcons();

    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    burgerBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });


  </script>
</body>
</html>
