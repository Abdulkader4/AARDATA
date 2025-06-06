<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | AARDATA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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
                <a href="{{ url('Welkome') }}" class="text-white hover:text-yellow-300 font-medium transition">Help</a>

    </div>
    <button onclick="downloadPDF()" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-300 transition">
        Download PDF
    </button>
</nav>

<!-- 📊 Dashboard Content -->
<main id="pdfContent" class="pt-24 px-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Welkom, {{ $loggedInStudentName }} ({{ $studentNumber }})</h1>

    <!-- 📦 Statistiekkaarten -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Aanwezigheid in procenten + label --}}
        <div class="bg-white text-black p-4 rounded shadow text-center">
            <p class="text-sm text-gray-500">Aanwezigheid</p>
            @php
                $label = match (true) {
                    $percentage === 100 => 'Perfect',
                    $percentage >= 95 => 'Excellent',
                    $percentage >= 80 => 'Goed',
                    $percentage >= 65 => 'Redelijk',
                    $percentage >= 50 => 'Onvoldoende',
                    $percentage >= 1 => 'Kritiek',
                    default => 'Fail'
                };
                $color = match (true) {
                    $percentage === 100 => 'text-green-700',
                    $percentage >= 95 => 'text-green-600',
                    $percentage >= 80 => 'text-emerald-500',
                    $percentage >= 65 => 'text-yellow-500',
                    $percentage >= 50 => 'text-orange-500',
                    $percentage >= 1 => 'text-red-500',
                    default => 'text-red-700'
                };
            @endphp
            <p class="text-2xl font-bold {{ $color }}">{{ $percentage }}% {{ $label }}</p>
        </div>

        {{-- Uitleg bij score --}}
        <div class="bg-white text-black p-4 rounded shadow text-center flex flex-col items-center">
            @if($percentage === 100)
                <p class="text-green-700 mb-2">Perfect! Je bent altijd aanwezig geweest. 🚀</p>
            @elseif($percentage >= 95)
                <p class="text-green-600 mb-2">Geweldig werk, bijna perfect!</p>
            @elseif($percentage >= 80)
                <p class="text-emerald-500 mb-2">Zeer goed gedaan, ga zo door!</p>
            @elseif($percentage >= 65)
                <p class="text-yellow-600 mb-2">Je doet het redelijk, blijf verbeteren.</p>
            @elseif($percentage >= 50)
                <p class="text-orange-500 mb-2">Let op! Je aanwezigheid is onvoldoende.</p>
            @elseif($percentage >= 1)
                <p class="text-red-500 mb-2">Je aanwezigheid is kritiek laag.</p>
            @else
                <p class="text-red-700 mb-2">0% aanwezigheid, dringend actie nodig!</p>
            @endif

            {{-- Cirkelgrafiek --}}
            <div class="w-36 h-36 mt-4">
                <canvas id="circleChart" width="144" height="144"></canvas>
            </div>
        </div>

        {{-- Filterformulier met studentNumber meegegeven --}}
        <form method="GET" action="{{ route('student.dashboard', ['studentNumber' => $studentNumber]) }}" class="bg-white text-black p-4 rounded shadow space-y-2">
            <label class="text-sm">Van</label>
            <input type="date" name="from" value="{{ $from }}" class="border rounded px-2 py-1 w-full">

            <label class="text-sm">Tot</label>
            <input type="date" name="to" value="{{ $to }}" class="border rounded px-2 py-1 w-full">

            <label class="text-sm">Week</label>
            <input type="number" name="week" value="{{ $week }}" class="border rounded px-2 py-1 w-full">

            <button type="submit" class="bg-yellow-400 text-black rounded px-4 py-2 w-full hover:bg-yellow-300">Filteren</button>
        </form>
    </div>

    <!-- 📋 Tabel met weekgegevens -->
    <div class="bg-white text-black p-4 rounded shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Week</th>
                    <th class="px-4 py-2">Jaar</th>
                    <th class="px-4 py-2">Minuten</th>
                    <th class="px-4 py-2">Percentage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $row)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $row['week'] }}</td>
                        <td class="px-4 py-2">{{ $row['year'] }}</td>
                        <td class="px-4 py-2">{{ $row['minutes'] }}m</td>
                        <td class="px-4 py-2">{{ $row['percentage'] }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Geen resultaten gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
    const percentage = {{ $percentage ?? 0 }};
    const ctx = document.getElementById('circleChart').getContext('2d');

    Chart.register({
        id: 'centerText',
        beforeDraw: (chart) => {
            const { width } = chart;
            const { ctx } = chart;
            const text = percentage + '%';
            ctx.restore();
            const fontSize = (width / 6);
            ctx.font = `${fontSize}px Segoe UI`;
            ctx.fillStyle = '#1d3557';
            ctx.textBaseline = 'middle';
            const textX = Math.round((chart.width - ctx.measureText(text).width) / 2);
            const textY = chart.height / 2;
            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    });

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Aanwezig', 'Afwezig'],
            datasets: [{
                data: [percentage, 100 - percentage],
                backgroundColor: ['#facc15', '#e5e7eb'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw}%`
                    }
                }
            }
        },
        plugins: ['centerText']
    });

    function downloadPDF() {
        setTimeout(() => {
            const element = document.getElementById('pdfContent');
            const opt = {
                margin: 0.5,
                filename: 'aanwezigheid-dashboard.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }, 300);
    }
</script>

</body>
</html>
