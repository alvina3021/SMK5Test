<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil RIASEC - Guru Area</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
            <span class="bg-white/20 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Guru Area</span>
        </div>
        <a href="{{ route('guru.dashboard') }}" class="text-white hover:text-[#FFE27A] font-semibold border-b-2 border-white pb-1">Dashboard</a>
    </nav>

    <main class="grow py-10 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-[#0A2A43] mb-6 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-indigo-600 px-6 py-5 border-b border-indigo-700">
                    <h2 class="text-xl font-bold text-white">Hasil Tes Minat (RIASEC)</h2>
                    <p class="text-indigo-100 text-sm mt-1">Siswa: {{ $user->name }}</p>
                </div>
                <div class="p-6">
                    @php
                        $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
                        if (is_array($answers)) {
                            foreach ($answers as $key => $val) {
                                if (array_key_exists($key, $scores) && is_array($val)) { $scores[$key] = count($val); } 
                                else { $type = substr(is_string($val) ? $val : $key, 0, 1); if (array_key_exists($type, $scores)) $scores[$type]++; }
                            }
                        }
                        arsort($scores);
                        $topKey = array_key_first($scores);
                        $labels = ['R' => 'Realistic', 'I' => 'Investigative', 'A' => 'Artistic', 'S' => 'Social', 'E' => 'Enterprising', 'C' => 'Conventional'];
                    @endphp

                    <div class="text-center mb-8 bg-indigo-50 py-6 rounded-xl border border-indigo-100">
                        <h3 class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-2">Dominasi Kepribadian</h3>
                        <div class="text-4xl font-extrabold text-indigo-700">{{ $topKey }} - {{ $labels[$topKey] }}</div>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100"><tr><th class="px-4 py-3">Tipe</th><th class="px-4 py-3 text-center">Skor</th><th class="px-4 py-3">Grafik</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($scores as $type => $score)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $type }} - {{ $labels[$type] }}</td>
                                <td class="px-4 py-3 text-center font-bold">{{ $score }}</td>
                                <td class="px-4 py-3"><div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($score > 0 ? ($score/42)*100 : 0) }}%"></div></div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>