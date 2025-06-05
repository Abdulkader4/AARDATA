<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Student Details | AARDATA</title>
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
    </div>
    <div class="flex gap-4">
        <a href="#" class="bg-gray-200 text-[#1d3557] px-4 py-2 rounded hover:bg-gray-100 transition font-medium">
            ⬅ Terug naar studenten overzicht
        </a>
        <button onclick="downloadPDF()" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-300 transition">
            Download PDF
        </button>
    </div>
</nav>

<!-- 🔍 Filters -->
<section class="max-w-6xl mx-auto pt-28 px-6">
    <div class="bg-white text-black p-6 rounded-xl shadow mb-8">
        <h2 class="text-xl font-bold text-[#1d3557] mb-4">📅 Filter Aanwezigheid</h2>
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Van datum</label>
                <input type="date" id="date_from" name="date_from" class="w-full px-3 py-2 border rounded-md text-[#1d3557]">
            </div>
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Tot datum</label>
                <input type="date" id="date_to" name="date_to" class="w-full px-3 py-2 border rounded-md text-[#1d3557]">
            </div>
            <div>
                <label for="week" class="block text-sm font-medium text-gray-700 mb-1">Week</label>
                <select id="week" name="week" class="w-full px-3 py-2 border rounded-md text-[#1d3557]">
                    <option value="">Alle weken</option>
                    @for ($i = 1; $i <= 20; $i++)
                        <option value="week{{ $i }}">Week {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="percentage_filter_type" class="block text-sm font-medium text-gray-700 mb-1">Filtertype</label>
                <select name="percentage_filter_type" id="percentage_filter_type" class="w-full px-3 py-2 border rounded-md text-[#1d3557]">
                    <option value="">-- Kies --</option>
                    <option value="less">Minder dan</option>
                    <option value="greater">Meer dan</option>
                </select>
            </div>
            <div>
                <label for="percentage_value" class="block text-sm font-medium text-gray-700 mb-1">Percentage</label>
                <input type="number" min="0" max="100" id="percentage_value" name="percentage_value" placeholder="Bijv. 20%" class="w-full px-3 py-2 border rounded-md text-[#1d3557]">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-2 rounded-md hover:bg-yellow-300 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>
</section>

<!-- 📊 Student Content -->
<main id="pdfContent" class="px-6 max-w-5xl mx-auto pb-16">
    <h1 class="text-3xl font-bold mb-8">Studentgegevens</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- 📄 Student Info -->
        <div class="bg-white text-black p-6 rounded-xl shadow space-y-3">
            <h2 class="text-lg font-semibold text-[#1d3557] mb-2">👤 Persoonlijke info</h2>
            <div class="border-t pt-2 space-y-2 text-sm">
                <p><span class="font-semibold text-gray-600">Naam:</span> {{ $student['naam'] }}</p>
                <p><span class="font-semibold text-gray-600">E-mail:</span> {{ $student['email'] }}</p>
                <p><span class="font-semibold text-gray-600">Studentnummer:</span> {{ $student['studentnummer'] }}</p>
                <p><span class="font-semibold text-gray-600">Klas:</span> {{ $student['klas'] ?? 'n.v.t.' }}</p>
                <p><span class="font-semibold text-gray-600">Status:</span> {{ $student['status'] ?? 'n.v.t.' }}</p>
            </div>
        </div>

        <!-- 🟡 Status label -->
        <div class="bg-white text-black p-6 rounded-xl shadow text-center flex flex-col justify-center">
            <h2 class="text-lg font-semibold text-[#1d3557] mb-2">📈 Aanwezigheid</h2>
            @php
                $percentage = $student['gemiddeld_aanwezigheid'] ?? 0;
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
            <p class="text-3xl font-bold {{ $color }}">{{ $percentage }}%<br><span class="text-base">{{ $label }}</span></p>
        </div>

        <!-- 📊 Grafiek -->
        <div class="bg-white text-black p-6 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold text-[#1d3557] mb-4">🧮 Cirkelgrafiek</h2>
            <div class="w-40 h-40 mx-auto">
                <canvas id="circleChart" width="160" height="160"></canvas>
            </div>
        </div>
    </div>
</main>

<script>
    const percentage = {{ $student['gemiddeld_aanwezigheid'] ?? 0 }};
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
                filename: 'student-details.pdf',
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
