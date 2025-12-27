<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styling Scrollbar Halus */
        .modal-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .modal-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .modal-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
        .modal-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-40">
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
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow p-6 md:p-10 relative z-0">
        <div class="max-w-7xl mx-auto">
            
            {{-- HEADER & FILTER --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#0A2A43]">Rekapitulasi Siswa</h1>
                    <p class="text-gray-600 mt-1">Pantau progres pengerjaan asesmen siswa.</p>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('guru.dashboard') }}" method="GET" class="flex items-center">
                        <div class="relative">
                            <select name="kelas" onchange="this.form.submit()" class="pl-4 pr-10 bg-white border border-[#0A2A43] text-[#0A2A43] py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition shadow-sm cursor-pointer focus:outline-none appearance-none">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasOptions as $kelas)
                                    <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-[#0A2A43]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL SISWA --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A2A43] text-white uppercase text-xs tracking-wider">
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] w-16">No</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e]">Nama Siswa</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e]">Kelas</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] text-center">Progress</th>
                                <th class="px-6 py-4 font-semibold border-b border-[#1a4a6e] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($rekapSiswa as $index => $siswa)
                            <tr class="hover:bg-[#F4F1FF] transition duration-150 group">
                                <td class="px-6 py-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-[#E0E7FF] text-[#0A2A43] flex items-center justify-center text-sm font-bold shadow-sm">
                                            {{ substr($siswa['nama'], 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-[#0A2A43] group-hover:text-blue-600 transition">{{ $siswa['nama'] }}</div>
                                            <div class="text-xs text-gray-400">NIS: {{ $siswa['nis'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium">
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs border border-gray-200 font-semibold">{{ $siswa['kelas'] }}</span>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="w-full max-w-[140px] mx-auto">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="font-semibold text-gray-600">{{ $siswa['total_selesai'] }}/{{ $siswa['total_tugas'] }}</span>
                                            <span class="text-blue-600 font-bold">{{ $siswa['persentase'] }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-{{ $siswa['persentase'] == 100 ? 'green-500' : 'blue-600' }} h-2 rounded-full transition-all duration-500" style="width: {{ $siswa['persentase'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openModal('modal-{{ $siswa['id'] }}')" 
                                            class="text-[#0A2A43] hover:text-white hover:bg-[#0A2A43] p-2 rounded-full transition duration-200 shadow-sm border border-transparent hover:border-[#0A2A43]" 
                                            title="Lihat Detail Tugas">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 bg-gray-50">
                                    <span class="font-medium">Belum ada data siswa ditemukan.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto z-0">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>


    {{-- ======================================================================= --}}
    {{-- MODAL AREA (FINAL FIX: CLICK OUTSIDE & HEIGHT) --}}
    {{-- ======================================================================= --}}
    
    @foreach($rekapSiswa as $siswa)
    
    {{-- 
      1. CONTAINER UTAMA (WRAPPER + BACKDROP):
      - fixed inset-0 z-[9999]: Menutupi seluruh layar di atas segalanya.
      - bg-gray-900/60: Warna gelap transparan.
      - flex items-center justify-center: Menaruh kotak putih di tengah.
      - onclick="closeModal": Menangkap klik di area gelap ini.
    --}}
    <div id="modal-{{ $siswa['id'] }}" 
         class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-gray-900/75 backdrop-blur-sm px-4 fade-in"
         onclick="closeModal('modal-{{ $siswa['id'] }}')">

        {{-- 
          2. KOTAK PUTIH MODAL:
          - onclick="event.stopPropagation()": KUNCI UTAMA! Mencegah klik di kotak ini "bocor" ke container luar (jadi modal tidak tertutup).
          - w-full max-w-md: Lebar medium yang pas.
          - max-h-[85vh]: Tinggi maksimal 85% layar.
          - flex flex-col: Menyusun Header-Body-Footer.
        --}}
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden transform scale-100"
             onclick="event.stopPropagation()">
            
            {{-- A. Header (Tetap Diam / Tidak Scroll) --}}
            <div class="flex-shrink-0 px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-white z-10">
                <div>
                    <h3 class="text-base font-bold text-[#0A2A43]">Detail Pengerjaan</h3>
                    <div class="flex items-center gap-2 text-[11px] mt-0.5 font-medium uppercase tracking-wide">
                        <span class="text-gray-700">{{ $siswa['nama'] }}</span>
                        <span class="text-gray-300">|</span>
                        <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">{{ $siswa['kelas'] }}</span>
                    </div>
                </div>
                {{-- Tombol Close --}}
                <button type="button" onclick="closeModal('modal-{{ $siswa['id'] }}')" class="p-1.5 rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- B. Body (Scrollable Area) --}}
            {{-- flex-1 + overflow-y-auto: Mengisi sisa ruang dan scroll jika konten panjang --}}
            <div class="flex-1 overflow-y-auto modal-scroll bg-gray-50/50 p-5">
                <div class="space-y-3">
                    @foreach($siswa['detail'] as $tugas)
                        @if($tugas['status'] == 'Sudah Mengerjakan')
                            <a href="{{ $tugas['url'] }}" class="group flex items-center justify-between bg-white p-3 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-green-500 transition-all duration-200 cursor-pointer text-decoration-none">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-50 flex items-center justify-center text-green-600 border border-green-100 group-hover:bg-green-600 group-hover:text-white transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-800 group-hover:text-green-700 transition">{{ $tugas['label'] }}</div>
                                        <div class="text-[10px] text-green-600 font-medium inline-block mt-0.5">Selesai dikerjakan</div>
                                    </div>
                                </div>
                                <div class="text-gray-300 group-hover:text-green-600 group-hover:translate-x-1 transition-all">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </a>
                        @else
                            <div class="flex items-center justify-between bg-gray-100 p-3 rounded-xl border border-gray-200 opacity-60">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-500">{{ $tugas['label'] }}</div>
                                        <div class="text-[10px] text-red-500 font-medium mt-0.5">Belum dikerjakan</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- C. Footer (Tetap Diam) --}}
            <div class="flex-shrink-0 bg-gray-50 px-5 py-3 border-t border-gray-100 text-center rounded-b-2xl">
                <button type="button" onclick="closeModal('modal-{{ $siswa['id'] }}')" class="text-xs font-bold text-gray-500 hover:text-gray-800 transition uppercase tracking-wider">
                    Tutup
                </button>
            </div>

        </div>
    </div>
    @endforeach

    <script>
        function openModal(modalID) {
            const modal = document.getElementById(modalID);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Kunci scroll body utama
            }
        }

        function closeModal(modalID) {
            const modal = document.getElementById(modalID);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Buka scroll body utama
            }
        }

        // Close on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                const modals = document.querySelectorAll('[id^="modal-"]:not(.hidden)');
                modals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    </script>
</body>
</html>