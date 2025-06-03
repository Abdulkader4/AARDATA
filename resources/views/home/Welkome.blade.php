<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Welkom bij AARDATA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <style>
    body {
      background: linear-gradient(135deg, #1d3557, #457b9d);
      font-family: 'Segoe UI', sans-serif;
    }
  </style>
</head>
<body class="text-white">

  <div class="flex flex-col justify-center items-center h-screen text-center px-4">

    <h1 class="text-4xl md:text-6xl font-bold mb-4" data-aos="fade-down">
      Welkom bij <span class="text-yellow-300">AARDATA</span>
    </h1>

    <p class="text-lg md:text-xl mb-8 max-w-2xl" data-aos="fade-up" data-aos-delay="200">
      Een slim platform voor digitale registratie van aanwezigheid en statistieken voor studenten en docenten.
    </p>

    <div class="flex flex-col md:flex-row gap-4" data-aos="zoom-in" data-aos-delay="400">
      <a href="" class="px-6 py-3 bg-yellow-400 text-black rounded-full shadow-lg hover:bg-yellow-300 transition-all duration-300">
        Ga naar Docentomgeving
      </a>
      <a href="#" class="px-6 py-3 bg-white text-blue-800 rounded-full shadow-lg hover:bg-gray-200 transition-all duration-300">
        Bekijk Studentstatistieken
      </a>
    </div>
  </div>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
