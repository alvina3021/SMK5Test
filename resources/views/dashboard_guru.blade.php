<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST <span class="text-[#FFE27A] text-sm font-sans tracking-wide ml-1 font-normal">| GURU PENGAMPU</span></span>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                    <div class="text-xs text-[#FFE27A]">Guru BK</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg border-2 border-[#FFE27A]">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-white/80 hover:text-[#FFE27A] transition text-sm font-semibold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow p-6 md:p-10">
        <div class="max-w-7xl mx-auto">

            {{-- JUDUL HALAMAN & FILTER --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#0A2A43]">Rekapitulasi Siswa</h1>
                    <p class="text-gray-600 mt-1">Pantau perkembangan pengerjaan tes asesmen siswa di sini.</p>
                </div>

                <div class="flex gap-3">
                    {{-- FORM FILTER KELAS (DROPDOWN) --}}
                    <form action="{{ route('guru.dashboard') }}" method="GET" class="flex items-center">
                        <div class="relative">
                            {{-- Icon Filter --}}
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#0A2A43]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>

                            {{-- Dropdown Select --}}
                            <select name="kelas" onchange="this.form.submit()" class="pl-10 pr-8 bg-white border border-[#0A2A43] text-[#0A2A43] py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#0A2A43] appearance-none">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasOptions as $kelas)
                                    <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Chevron Down Icon (Custom) --}}
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-[#0A2A43]">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A2A43] text-white uppercase text-xs tracking-wider">
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e]">No</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e]">Nama Siswa</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e]">Kelas</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] text-center">Data Pribadi</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] text-center">RIASEC</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($rekapSiswa as $index => $siswa)
                            <tr class="hover:bg-[#F4F1FF] transition duration-150">
                                <td class="px-6 py-4 font-medium text-gray-500">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ substr($siswa['nama'], 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-[#0A2A43]">{{ $siswa['nama'] }}</div>
                                            <div class="text-xs text-gray-400">NIS: {{ $siswa['nis'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs border border-gray-200">
                                        {{ $siswa['kelas'] }}
                                    </span>
                                </td>

                                {{-- Status Data Pribadi --}}
                                <td class="px-6 py-4 text-center">
                                    @if($siswa['data_pribadi']['status'] == 'Selesai')
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Selesai
                                            </span>
                                            <span class="text-[10px] text-gray-400 mt-1">{{ $siswa['data_pribadi']['tanggal'] }}</span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Belum
                                        </span>
                                    @endif
                                </td>

                                {{-- Status RIASEC --}}
                                <td class="px-6 py-4 text-center">
                                    @if($siswa['riasec']['status'] == 'Selesai')
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                                Selesai
                                            </span>
                                            {{-- Menampilkan Hasil Singkat --}}
                                            @if($siswa['riasec']['hasil'] !== '-')
                                                <span class="text-[10px] font-bold text-[#0A2A43] mt-1 tracking-wide">
                                                    {{ $siswa['riasec']['hasil'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                            Belum
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <button class="text-[#0A2A43] hover:text-[#FFE27A] hover:bg-[#0A2A43] p-2 rounded-full transition duration-200" title="Lihat Detail Siswa">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <span>Belum ada siswa yang menyelesaikan tes.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Tabel --}}
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Menampilkan {{ count($rekapSiswa) }} data</span>
                </div>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>
