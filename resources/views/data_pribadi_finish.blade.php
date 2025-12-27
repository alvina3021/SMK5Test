<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Data Pribadi - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        /* Custom scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            {{-- 1. DASHBOARD: DIUBAH MENJADI NON-AKTIF (Border Transparent) --}}
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-white pb-1 border-b-2 border-transparent transition">
                    Dashboard
                </a>
            </li>

            {{-- 2. TES SAYA: DIUBAH MENJADI AKTIF (Border White + Text White + Hover Kuning) --}}
            <li>
                <a href="{{ route('tes.saya') }}" class="text-white border-b-2 border-white pb-1 hover:text-[#FFE27A] transition">
                    Tes Saya
                </a>
            </li>
        </ul>

        {{-- PROFIL & LOGOUT --}}
        @auth
        {{-- Link ke Halaman Profile --}}
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 ml-auto hover:opacity-90 transition group">

            {{-- Nama User --}}
            <span class="text-white text-base font-semibold hidden sm:block group-hover:text-[#FFE27A] transition">
                {{ explode(' ', $user->name)[0] }}
            </span>

            {{-- Avatar User --}}
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer overflow-hidden border-2 border-transparent group-hover:border-[#FFE27A] transition">
                @if($user->profile_photo_path)
                    {{-- Tampilkan Foto Jika Ada --}}
                    <img src="{{ asset('public/app/public/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="grow py-10 px-4 md:px-10 flex justify-center">
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: PROFIL UTAMA & KELUARGA (STICKY) --}}
            <div class="lg:col-span-1 flex flex-col gap-6 animate-fade-in-up">

                {{-- KARTU FOTO & DATA UTAMA --}}
                <div class="bg-white shadow-xl rounded-2xl p-6 text-center border-t-8 border-[#FFE27A] relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-bl-lg">
                        Tersimpan
                    </div>

                    <div class="w-32 h-32 mx-auto bg-gray-200 rounded-full p-1 border-4 border-[#0A2A43] overflow-hidden mb-4 shadow-lg group relative">
                        @if(isset($dataSiswa->foto_profil_path) && $dataSiswa->foto_profil_path)
                            <img src="{{ asset('public/app/public/' . $dataSiswa->foto_profil_path) }}" class="w-full h-full object-cover rounded-full transition transform group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-gray-400 bg-gray-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-[#0A2A43] mb-1 leading-tight">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-4">{{ $user->email }}</p>

                    <div class="bg-[#F4F1FF] rounded-lg p-4 text-left space-y-3 border border-gray-100 text-sm">
                        <div class="flex justify-between border-b border-gray-200 pb-1">
                            <span class="text-gray-500">Jenis Kelamin</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-1">
                            <span class="text-gray-500">Agama</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->agama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-1">
                            <span class="text-gray-500">Tanggal Lahir</span>
                            <span class="font-semibold text-[#0A2A43]">
                                {{ isset($dataSiswa->tanggal_lahir) ? \Carbon\Carbon::parse($dataSiswa->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tempat Lahir</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->tempat_lahir ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- KARTU KELUARGA --}}
                <div class="bg-[#0A2A43] text-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-xs uppercase tracking-widest text-gray-400 mb-4 border-b border-white/20 pb-2">Status Keluarga</h3>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-white/10 rounded-lg p-2">
                            <span class="block text-[10px] text-gray-300 uppercase">Anak Ke</span>
                            <span class="text-2xl font-bold text-[#FFE27A]">{{ $dataSiswa->anak_ke ?? '-' }}</span>
                        </div>
                        <div class="bg-white/10 rounded-lg p-2">
                            <span class="block text-[10px] text-gray-300 uppercase">Jml Saudara</span>
                            <span class="text-2xl font-bold text-[#FFE27A]">{{ $dataSiswa->jumlah_saudara ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <span class="block text-[10px] text-gray-400 uppercase mb-1">Status Anak</span>
                        <span class="inline-block bg-[#FFE27A] text-[#0A2A43] px-3 py-1 rounded-full text-xs font-bold">
                            {{ $dataSiswa->status_anak ?? '-' }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: DETAIL DATA --}}
            <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl p-8 animate-fade-in-up flex flex-col h-fit relative" style="animation-delay: 0.1s;">

                {{-- Toolbar Atas --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 border-b pb-4 gap-4">
                    <h3 class="text-xl font-bold text-[#0A2A43] flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#FFE27A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Rincian Data Lengkap
                    </h3>
                    <a href="{{ route('tes.saya') }}" class="flex items-center gap-2 bg-[#0A2A43] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#153e5e] transition shadow-lg">
                        Kembali ke Tes Saya
                    </a>
                </div>

                <div class="space-y-8 custom-scroll overflow-y-auto pr-2" style="max-height: 800px;">

                    {{-- SECTION 1: KONTAK & PERSONAL --}}
                    <section>
                        <h4 class="text-sm font-bold text-[#0A2A43] uppercase mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#FFE27A] rounded-full"></span> Kontak & Personal
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-xs text-gray-500 uppercase block mb-1">Alamat Rumah</span>
                                <p class="text-gray-800 font-medium text-sm leading-snug">{{ $dataSiswa->alamat ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-xs text-gray-500 uppercase block mb-1">Status Tempat Tinggal</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->kepemilikan_rumah ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-xs text-gray-500 uppercase block mb-1">No. HP Siswa</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->no_hp ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-xs text-gray-500 uppercase block mb-1">Hobi</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->hobi ?? '-' }}</p>
                            </div>
                        </div>
                        {{-- Kelebihan & Kelemahan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                                <span class="text-xs text-green-700 font-bold uppercase block mb-1">Kelebihan Diri</span>
                                <p class="text-gray-700 text-sm italic">"{{ $dataSiswa->kelebihan ?? '-' }}"</p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                                <span class="text-xs text-red-700 font-bold uppercase block mb-1">Kelemahan Diri</span>
                                <p class="text-gray-700 text-sm italic">"{{ $dataSiswa->kelemahan ?? '-' }}"</p>
                            </div>
                        </div>
                    </section>

                    {{-- SECTION 2: DATA EKONOMI --}}
                    <section>
                        <h4 class="text-sm font-bold text-[#0A2A43] uppercase mb-3 flex items-center gap-2 border-t pt-6">
                            <span class="w-2 h-2 bg-[#FFE27A] rounded-full"></span> Data Ekonomi & Bantuan
                        </h4>
                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <span class="text-xs text-blue-600 font-bold uppercase block mb-1">Uang Saku (Harian)</span>
                                    <p class="text-lg font-bold text-[#0A2A43]">{{ $dataSiswa->uang_saku ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-blue-600 font-bold uppercase block mb-1">Bantuan Pemerintah</span>
                                    <p class="text-sm font-semibold text-[#0A2A43]">
                                        {{ $bantuan ?? 'Tidak Menerima Bantuan' }}
                                    </p>
                                </div>
                            </div>

                            @if(isset($dataSiswa->foto_kartu_bantuan_path) && $dataSiswa->foto_kartu_bantuan_path)
                                <div class="mt-4 pt-4 border-t border-blue-200">
                                    <span class="text-xs text-blue-600 font-bold uppercase block mb-2">Bukti Kartu Bantuan</span>
                                    <div class="w-full max-w-xs h-32 bg-gray-200 rounded-lg overflow-hidden border border-gray-300">
                                        <img src="{{ asset('public/app/public/' . $dataSiswa->foto_kartu_bantuan_path) }}" class="w-full h-full object-cover cursor-pointer hover:scale-105 transition" onclick="window.open(this.src)">
                                    </div>
                                    <p class="text-[10px] text-blue-400 mt-1">*Klik gambar untuk memperbesar</p>
                                </div>
                            @endif
                        </div>
                    </section>

                    {{-- SECTION 3: DATA ORANG TUA --}}
                    <section>
                        <h4 class="text-sm font-bold text-[#0A2A43] uppercase mb-3 flex items-center gap-2 border-t pt-6">
                            <span class="w-2 h-2 bg-[#FFE27A] rounded-full"></span> Data Orang Tua
                        </h4>

                        <div class="text-center mb-4">
                            <span class="text-xs text-gray-500 uppercase">Status Orang Tua:</span>
                            <span class="font-bold text-[#0A2A43]">{{ $dataSiswa->status_orang_tua ?? '-' }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- AYAH --}}
                            <div class="border border-gray-200 rounded-xl p-5 relative bg-white hover:shadow-md transition">
                                <span class="absolute -top-3 left-4 bg-[#0A2A43] text-white px-3 py-0.5 rounded-full text-[10px] font-bold tracking-wider">AYAH</span>
                                <div class="space-y-3 text-sm mt-2">
                                    <div><span class="block text-xs text-gray-400">Nama Lengkap</span> <span class="font-bold text-gray-800">{{ $dataSiswa->nama_ayah ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Status</span> <span class="font-medium text-gray-700">{{ $dataSiswa->status_ayah ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Pekerjaan</span> <span class="font-medium text-gray-700">{{ $dataSiswa->pekerjaan_ayah ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Penghasilan</span> <span class="font-medium text-green-600">{{ $dataSiswa->gaji_ayah ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">No. HP</span> <span class="font-medium text-blue-600">{{ $dataSiswa->no_hp_ayah ?? '-' }}</span></div>
                                </div>
                            </div>

                            {{-- IBU --}}
                            <div class="border border-gray-200 rounded-xl p-5 relative bg-white hover:shadow-md transition">
                                <span class="absolute -top-3 left-4 bg-pink-600 text-white px-3 py-0.5 rounded-full text-[10px] font-bold tracking-wider">IBU</span>
                                <div class="space-y-3 text-sm mt-2">
                                    <div><span class="block text-xs text-gray-400">Nama Lengkap</span> <span class="font-bold text-gray-800">{{ $dataSiswa->nama_ibu ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Status</span> <span class="font-medium text-gray-700">{{ $dataSiswa->status_ibu ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Pekerjaan</span> <span class="font-medium text-gray-700">{{ $dataSiswa->pekerjaan_ibu ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">Penghasilan</span> <span class="font-medium text-green-600">{{ $dataSiswa->gaji_ibu ?? '-' }}</span></div>
                                    <div><span class="block text-xs text-gray-400">No. HP</span> <span class="font-medium text-blue-600">{{ $dataSiswa->no_hp_ibu ?? '-' }}</span></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- SECTION 4: DATA WALI (Hanya jika diisi) --}}
                    @if($dataSiswa->nama_wali && $dataSiswa->nama_wali !== '-')
                    <section>
                        <h4 class="text-sm font-bold text-[#0A2A43] uppercase mb-3 flex items-center gap-2 border-t pt-6">
                            <span class="w-2 h-2 bg-[#FFE27A] rounded-full"></span> Data Wali
                        </h4>
                        <div class="border border-gray-200 rounded-xl p-5 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                                <div><span class="block text-xs text-gray-400">Nama Wali</span> <span class="font-bold text-gray-800">{{ $dataSiswa->nama_wali }}</span></div>
                                <div><span class="block text-xs text-gray-400">Hubungan</span> <span class="font-medium text-gray-700">-</span></div> {{-- Tambahkan kolom hubungan di DB jika perlu --}}
                                <div><span class="block text-xs text-gray-400">Pekerjaan</span> <span class="font-medium text-gray-700">{{ $dataSiswa->pekerjaan_wali }}</span></div>
                                <div><span class="block text-xs text-gray-400">Alamat</span> <span class="font-medium text-gray-700">{{ $dataSiswa->alamat_wali }}</span></div>
                                <div><span class="block text-xs text-gray-400">No. HP</span> <span class="font-medium text-blue-600">{{ $dataSiswa->no_hp_wali }}</span></div>
                            </div>
                        </div>
                    </section>
                    @endif

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
