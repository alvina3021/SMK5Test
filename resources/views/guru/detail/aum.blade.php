<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil AUM - Guru Area</title>
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
        <div class="max-w-5xl mx-auto">
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-[#0A2A43] mb-6 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-red-50 px-6 py-6 border-b border-red-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-red-800">Hasil AUM (Masalah)</h2>
                        <p class="text-red-600">Siswa: {{ $user->name }}</p>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm text-center">
                        <span class="block text-xs text-gray-500 uppercase font-bold">Total</span>
                        <span class="text-2xl font-bold text-red-600">{{ count($masalah) }}</span>
                    </div>
                </div>

                <div class="p-6">
                    @if(count($masalahBerat) > 0)
                    <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-5">
                        <h3 class="flex items-center text-lg font-bold text-red-700 mb-3">⚠️ Masalah Berat</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($masalahBerat as $mb) <li class="text-red-800 font-medium">{{ $mb }}</li> @endforeach
                        </ul>
                    </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Daftar Semua Masalah</h3>
                    @if(count($masalah) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($masalah as $m)
                            <div class="flex items-start p-3 bg-gray-50 rounded border border-gray-100">
                                <span class="text-red-400 mr-2">•</span> <span class="text-gray-700">{{ $m }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-10">Tidak ada masalah yang dipilih.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>
</html>