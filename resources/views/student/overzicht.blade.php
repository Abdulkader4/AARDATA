<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Studentenoverzicht | AARDATA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen text-white">

<!-- 🔝 Navbar -->
<nav class="bg-[#1d3557] shadow-md px-6 py-4 flex justify-between items-center fixed top-0 left-0 right-0 z-50">
    <div class="flex items-center gap-4">
        <h1 class="text-xl font-bold text-yellow-300">AARDATA</h1>
        <a href="{{ url('Welkome') }}" class="text-white hover:text-yellow-300 font-medium transition">Home</a>
    </div>
</nav>

<!-- 📋 Studentenoverzicht -->
<main class="pt-24 px-6 max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Overzicht studenten</h1>

    <div class="bg-white text-black p-4 rounded shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Studentnummer</th>
                    <th class="px-4 py-2">Naam</th>
                    <th class="px-4 py-2">Aanwezigheid</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $student['nummer'] }}</td>
                        <td class="px-4 py-2">{{ $student['naam'] }}</td>
                        <td class="px-4 py-2">
                            <span class="font-bold">
                                {{ $student['percentage'] }}%
                            </span>
                            <span class="text-sm text-gray-500 ml-2">
                                {{ match (true) {
                                    $student['percentage'] === 100 => 'Perfect',
                                    $student['percentage'] >= 95 => 'Excellent',
                                    $student['percentage'] >= 80 => 'Goed',
                                    $student['percentage'] >= 65 => 'Redelijk',
                                    $student['percentage'] >= 50 => 'Onvoldoende',
                                    $student['percentage'] >= 1 => 'Kritiek',
                                    default => 'Afwezig'
                                } }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Geen studenten gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
