<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUM Langkah 2 & 3 - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

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

    <main class="grow py-8 px-4 md:px-10">
        <div class="max-w-4xl mx-auto">

            <form action="{{ route('aum.finish') }}" method="POST">
                @csrf

                {{-- --- BAGIAN LANGKAH KEDUA --- --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <div class="bg-[#0A2A43] text-white p-6 border-b-4 border-[#FFE27A]">
                        <div class="flex items-center gap-3">
                            <span class="bg-[#FFE27A] text-[#0A2A43] font-bold px-3 py-1 rounded text-sm">Langkah Kedua</span>
                            <h2 class="text-xl font-bold">Masalah yang Paling Berat</h2>
                        </div>
                        <p class="text-white/80 text-sm mt-2">
                            Di bawah ini adalah daftar masalah yang <b>telah Anda pilih</b> pada langkah pertama.
                        </p>
                    </div>

                    <div class="p-6 bg-[#F4F1FF]">

                        {{-- DAFTAR MASALAH YANG DIPILIH (HANYA TAMPILAN) --}}
                        <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6 shadow-sm">
                            <h3 class="font-bold text-[#0A2A43] mb-3 border-b pb-2">Daftar Pilihan Anda:</h3>
                            @if(empty($selectedProblems))
                                <p class="text-gray-500 italic">Tidak ada masalah yang dipilih.</p>
                            @else
                                <ul class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                    @foreach($selectedProblems as $problem)
                                        <li class="flex gap-3 text-sm text-gray-700 bg-gray-50 p-2 rounded">
                                            <span class="font-bold text-[#0A2A43] min-w-[30px]">{{ $problem['id'] }}.</span>
                                            <span>{{ $problem['text'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- KOTAK INPUT TEXT AREA (MASALAH TERBERAT) --}}
                        <div class="bg-yellow-50 rounded-lg border-2 border-[#FFE27A] p-5">
                            <label for="heavy_problem_desc" class="block font-bold text-[#0A2A43] text-lg mb-2">
                                Masalah mana yang paling berat / mengganggu?
                            </label>
                            <p class="text-sm text-gray-600 mb-3">
                                Silakan <b>tuliskan kembali</b> atau ceritakan masalah yang menurut Anda paling berat dari daftar di atas.
                            </p>

                            <textarea
                                name="heavy_problem_desc"
                                id="heavy_problem_desc"
                                rows="4"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#0A2A43] focus:ring-[#0A2A43] transition p-4"
                                placeholder="Contoh: Masalah nomor 001 dan 031 sangat mengganggu saya karena..."
                                required></textarea>
                        </div>

                    </div>
                </div>

                {{-- --- BAGIAN LANGKAH KETIGA (Sama seperti sebelumnya) --- --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-[#0A2A43] text-white p-6 border-b-4 border-[#FFE27A]">
                         <div class="flex items-center gap-3">
                            <span class="bg-[#FFE27A] text-[#0A2A43] font-bold px-3 py-1 rounded text-sm">Langkah Ketiga</span>
                            <h2 class="text-xl font-bold">Pertanyaan Tambahan</h2>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        {{-- Pertanyaan A --}}
                        <div class="space-y-3">
                            <label class="font-bold text-[#0A2A43] block">A. Apakah masalah-masalah tersebut ingin Anda bicarakan dengan orang lain?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2"><input type="radio" name="q_a" value="Ya" class="text-[#0A2A43]" required> <span>Ya</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="q_a" value="Tidak" class="text-[#0A2A43]"> <span>Tidak</span></label>
                            </div>
                        </div>

                        {{-- Pertanyaan B (Checkboxes) --}}
                        <div class="space-y-3">
                            <label class="font-bold text-[#0A2A43] block">B. Jika YA, kepada siapakah Anda ingin membicarakannya?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @php $optionsB = ['Guru Pembimbing (BK)', 'Guru Mata Pelajaran', 'Wali Kelas', 'Orang Tua', 'Teman Akrab', 'Sahabat', 'Pacar', 'Ahli Lain']; @endphp
                                @foreach($optionsB as $opt)
                                    <label class="flex items-center gap-2"><input type="checkbox" name="q_b[]" value="{{ $opt }}" class="text-[#0A2A43] rounded"><span class="text-sm">{{ $opt }}</span></label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Pertanyaan C --}}
                        <div class="space-y-3">
                            <label class="font-bold text-[#0A2A43] block">C. Apakah Anda ingin memperoleh bantuan?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2"><input type="radio" name="q_c" value="Ya" class="text-[#0A2A43]" required> <span>Ya</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="q_c" value="Tidak" class="text-[#0A2A43]"> <span>Tidak</span></label>
                            </div>
                        </div>

                        {{-- Pertanyaan D --}}
                        <div class="space-y-3">
                            <label class="font-bold text-[#0A2A43] block">D. Kapan Anda mau berkonsultasi?</label>
                            <input type="text" name="q_d" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0A2A43] focus:ring-[#0A2A43]">
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="p-6 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between gap-4">
                            <a href="{{ route('aum.form') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200 flex items-center justify-center gap-2">
                                Kembali
                            </a>
                            <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 flex items-center justify-center gap-2 text-center">
                                SELESAI
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
