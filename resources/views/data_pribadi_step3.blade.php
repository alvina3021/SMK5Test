<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wali - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styling radio button konsisten */
        .custom-radio input[type="radio"]:checked + div {
            border-color: #0A2A43;
            background-color: #eef2ff;
        }
        .custom-radio input[type="radio"]:checked + div .radio-circle {
            border-color: #0A2A43;
            border-width: 5px;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">

   {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
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
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">
            {{-- Indikator Halaman --}}
            <div class="flex justify-between items-center mb-6">
                <div class="text-[#0A2A43] font-bold text-lg">Halaman 3 dari 3</div>
                <div class="text-gray-500 font-semibold">Data Wali</div>
            </div>

            {{-- TAMBAHKAN KODE INI UNTUK MENAMPILKAN ERROR --}}
            {{--@if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            {{-- AKHIR KODE ERROR --}}

            {{-- Form Action mengarah ke store_step3 (Pastikan route ini dibuat di web.php) --}}
            <form action="{{ route('data_pribadi.store_step3') }}" method="POST" class="bg-white shadow-xl rounded-xl p-8 space-y-8">
                @csrf

                {{-- ==================== DATA WALI ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                    <p class="font-bold text-[#0A2A43]">DATA WALI</p>
                    <p class="text-sm text-gray-600">
                        Data wali diisi jika memiliki wali (yang bertanggung jawab atas pendidikan siswa, selain orang tua atau orang lain yang diserahi tanggungjawab oleh orang tua atas diri siswa).
                        <strong>Jika tidak ada wali silahkan dikosongi.</strong>
                    </p>
                </div>

                {{-- 35. NAMA WALI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $dataSiswa->nama_wali ?? '') }}" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Nama Lengkap Wali">
                </div>

                {{-- 36. ALAMAT WALI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Alamat Wali</label>
                    <textarea name="alamat_wali" rows="2"
                            class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition"
                            placeholder="Alamat Lengkap Wali">{{ old('alamat_wali', $dataSiswa->alamat_wali ?? '') }}</textarea>
                </div>

                {{-- 37. PENDIDIKAN WALI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pendidikan Wali</label>
                    <div class="space-y-2 custom-radio">
                        {{-- Opsi disesuaikan dengan Screenshot 2025-11-22 150236.png --}}
                        @foreach (['SD', 'SMP', 'SMA/ SMK', 'Diploma - S1', 'S2 - S3', 'Lain-lain'] as $pddk_wali)
                        <label class="cursor-pointer block">
                            <input type="radio" name="pendidikan_wali" value="{{ $pddk_wali }}" class="hidden" @checked(old('pendidikan_wali', $dataSiswa->pendidikan_wali ?? '') == $pddk_wali)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $pddk_wali }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 38. PEKERJAAN WALI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pekerjaan Wali</label>
                    <input type="text" name="pekerjaan_wali"
                        value="{{ old('pekerjaan_wali', $dataSiswa->pekerjaan_wali ?? '') }}"
                        class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition"
                        placeholder="Pekerjaan Wali">
                </div>

                {{-- 39. PENGHASILAN WALI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Penghasilan Wali</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['< 500.000', '500.000 s.d 2.000.000', '2.000.000 s.d 3.500.000', '3.500.000 s.d 5.000.000', '5.000.000 s.d 10.000.000', '> 10.000.000'] as $gaji_wali)
                        <label class="cursor-pointer block">
                            <input type="radio" name="penghasilan_wali" value="{{ $gaji_wali }}" class="hidden"
                                @checked(old('penghasilan_wali', $dataSiswa->penghasilan_wali ?? '') == $gaji_wali)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $gaji_wali }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 40. NO TELP WALI AKTIF --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">No Telp Wali aktif</label>
                    <input type="tel" name="no_hp_wali"
                        value="{{ old('no_hp_wali', $dataSiswa->no_hp_wali ?? '') }}"
                        class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition"
                        placeholder="08xxx">
                </div>

                {{-- NAVIGASI BUTTONS --}}
                <div class="mt-10 flex justify-between gap-4">
                    {{-- Tombol Kembali ke Step 2 --}}
                    <a href="{{ route('data_pribadi.step2') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>

                    {{-- Tombol Submit Akhir --}}
                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>


