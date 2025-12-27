<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil {{ $config['title'] }} - Guru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- NAVBAR (Dicopy dari template dashboard/aum kamu agar seragam) --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
            <span class="bg-white/20 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Guru Area</span>
        </div>

        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('guru.dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard Guru</a></li>
        </ul>

        <div class="flex items-center gap-3">
            @auth
                <span class="text-white text-sm font-semibold hidden sm:block">
                    {{ Auth::user()->name }}
                </span>
                <div class="w-8 h-8 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endauth
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="grow py-10 px-4">
        <div class="max-w-4xl mx-auto">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-[#0A2A43] mb-6 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                {{-- Header Card --}}
                <div class="bg-blue-600 px-6 py-5 border-b border-blue-700">
                    <h2 class="text-xl font-bold text-white">Hasil {{ $config['title'] }}</h2>
                    <div class="flex items-center gap-2 text-blue-100 mt-1 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Siswa: {{ $user->name }}
                    </div>
                </div>
        
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 border-b font-bold">No. / Pertanyaan</th>
                                    <th class="px-6 py-4 border-b font-bold text-center">Jawaban Siswa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($answers as $key => $value)
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="px-6 py-4 font-medium text-gray-700">
                                        @if(is_numeric($key)) 
                                            <span class="text-gray-400 mr-1">#</span> Soal No. {{ $key }}
                                        @else 
                                            {{ $key }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                            {{ is_array($value) ? implode(', ', $value) : $value }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-gray-500 italic bg-gray-50">
                                        Tidak ada data jawaban yang tersimpan untuk tes ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-right">
                    <span class="text-xs text-gray-500">Total Item: {{ count($answers) }}</span>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>