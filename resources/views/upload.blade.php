<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Upload AAR Bestand | AARDATA</title>
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
<body class="text-white min-h-screen flex items-center justify-center px-4 py-8 sm:py-12">

    {{-- Container --}}
    <div class="bg-white text-gray-800 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-lg sm:max-w-xl" data-aos="fade-up">
        {{-- Titel --}}
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center text-blue-800">Upload AAR Bestand</h1>

        {{-- Terug naar Home-knop --}}
        <form action="Welkome" method="GET" class="mb-6">
            <button type="submit" class="ml-1 text-xs sm:text-sm bg-white text-blue-800 font-medium px-3 py-1.5 rounded-full shadow hover:bg-gray-100 transition">
                ← Terug naar Home
            </button>
        </form>

        {{-- Flashmeldingen --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Uploadformulier --}}
        <form id="uploadForm" action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="file" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="button" onclick="openModal()" class="bg-yellow-400 text-black px-6 py-3 rounded-full hover:bg-yellow-300 transition w-full">
                Uploaden
            </button>
        </form>

        {{-- Voorbeelddata (optioneel) --}}
        @if(!empty($data))
            <div class="mt-8">
                <h2 class="text-lg sm:text-xl font-semibold mb-2 text-center text-blue-900">Voorbeeldinhoud</h2>
                <div class="overflow-auto max-h-[300px] border rounded">
                    <table class="min-w-full text-sm">
                        @foreach($data as $index => $row)
                            <tr class="{{ $index === 0 ? 'font-bold bg-gray-200' : 'bg-white' }}">
                                @foreach($row as $cell)
                                    <td class="border px-4 py-2 text-gray-700">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Bevestigingsmodal --}}
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden px-4">
        <div class="bg-white text-gray-800 rounded-lg p-4 sm:p-6 max-w-md w-full shadow-lg">
            <h2 class="text-lg sm:text-xl font-bold mb-4 text-blue-800">Bevestig Upload</h2>
            <p class="mb-6 text-sm sm:text-base">Weet je zeker dat je dit bestand wilt uploaden? De gegevens worden opgeslagen in het systeem.</p>
            <div class="flex justify-end flex-wrap gap-3">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition w-full sm:w-auto">Annuleer</button>
                <button onclick="submitForm()" class="px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-300 transition w-full sm:w-auto">Bevestigen</button>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('uploadForm').submit();
        }
    </script>
</body>
</html>
