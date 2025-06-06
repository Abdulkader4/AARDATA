<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <title>Welkom bij AARDATA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      background: linear-gradient(135deg, #1d3557, #457b9d);
      font-family: 'Segoe UI', sans-serif;
    }

    .typewriter-text span {
      border-right: 2px solid #fff;
      animation: blink 0.8s infinite;
    }

    @keyframes blink {

      0%,
      100% {
        border-color: transparent;
      }

      50% {
        border-color: #fff;
      }
    }
  </style>
</head>

<body class="text-white">

  <!-- Navbar -->
  <nav
    class="w-full px-4 py-3 flex items-center justify-between fixed top-0 left-0 z-50 bg-[#1d3557] bg-opacity-90 backdrop-blur">
    <div class="flex items-center gap-3">

      <span class="text-xl font-bold text-yellow-400 hidden sm:inline">AARDATA</span>

    </div>
    <div class="md:hidden">
      <button id="burgerBtn" class="text-white focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-full bg-[#1d3557] p-4 z-40 shadow-md">
    <a href="#"
      class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Docentomgeving</a>
    <a href="#"
      class="block py-2 px-4 text-white text-center hover:text-yellow-300 hover:bg-white/10 rounded transition">Studentstatistieken</a>
  </div>

  <!-- Content -->
  <div class="flex flex-col justify-center items-center min-h-screen text-center px-4 pt-40">
    <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-4 flex items-center gap-2" data-aos="fade-down">
      <i class="fas fa-database text-yellow-300 text-4xl"></i>
      Welkom bij <span class="text-yellow-300">AARDATA</span>
    </h1>

    <!-- Typewriter effect -->
    <div class="typewriter-text text-base sm:text-lg md:text-xl mb-4 h-6">
      <span id="typewriter-text"></span>
    </div>

    <p class="text-base sm:text-lg md:text-xl mb-8 max-w-2xl flex items-center justify-center gap-2" data-aos="fade-up"
      data-aos-delay="200">
      Een slim platform voor digitale registratie van aanwezigheid en statistieken.
    </p>

    <div class="flex flex-col md:flex-row gap-4" data-aos="zoom-in" data-aos-delay="400">
      <a href="{{ route('docent.form') }}"
        class="px-6 py-3 bg-yellow-400 text-black font-medium rounded-full shadow-lg hover:bg-yellow-300 transition-all duration-300 flex items-center gap-2">
        <i class="fas fa-chalkboard-teacher text-lg"></i>
        Ga naar Docentomgeving
      </a>

      <a href="{{ route('student.form') }}"
        class="px-6 py-3 bg-white text-blue-800 font-medium rounded-full shadow-lg hover:bg-gray-200 transition-all duration-300 flex items-center gap-2">
        <i class="fas fa-users text-lg"></i>
        Bekijk Studentstatistieken
      </a>

      <a href="{{ route('info.page') }}"
      class="px-6 py-3 bg-sky-500 text-white font-medium rounded-full shadow-lg hover:bg-sky-400 transition-all duration-300 flex items-center gap-2">
      <i class="fas fa-circle-question text-lg"></i>
      Hulp & Info
    </a>
    </div>

    <!-- Features -->
    <div class="mt-12 space-y-2">
      <p class="text-sm md:text-base"><i class="fas fa-check text-green-400"></i> Automatische gegevensverwerking</p>
      <p class="text-sm md:text-base"><i class="fas fa-check text-green-400"></i> Real-time rapportage voor docenten</p>
      <p class="text-sm md:text-base"><i class="fas fa-check text-green-400"></i> Eenvoudige toegang voor studenten</p>
    </div>

    <!-- Extra call-to-action -->
    <div class="mt-6">
      <a href="/demo" class="underline text-sm text-white hover:text-yellow-300">
      </a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();

    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    burgerBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Typewriter effect
    const phrases = [
      "Slim. Veilig. Digitaal.",
      "Voor studenten én docenten.",
      "Realtime inzicht in aanwezigheid."
    ];
    let i = 0, j = 0, isDeleting = false;
    const element = document.getElementById("typewriter-text");

    function type() {
      const current = phrases[i];
      if (!isDeleting && j <= current.length) {
        element.innerText = current.substring(0, j++);
        setTimeout(type, 100);
      } else if (isDeleting && j > 0) {
        element.innerText = current.substring(0, j--);
        setTimeout(type, 50);
      } else {
        isDeleting = !isDeleting;
        if (!isDeleting) i = (i + 1) % phrases.length;
        setTimeout(type, 1000);
      }
    }
    type();
  </script>
</body>

</html>
