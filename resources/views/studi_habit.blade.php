<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Studi Habit - SMK5TEST</title>
    {{-- Pastikan Vite terload --}}
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

            {{-- PERBAIKAN: Menambahkan route('tes.saya') pada href --}}
            <li><a href="{{ route('tes.saya') }}" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
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

    <main class="flex-grow flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-4xl">

            {{-- TOMBOL KEMBALI --}}
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="flex items-center text-[#0A2A43] font-semibold hover:text-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            {{-- KARTU UTAMA --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                {{-- HEADER BIRU --}}
                <div class="bg-[#0A2A43] text-white p-6 md:p-8">
                    <h1 class="text-2xl font-bold">Tes Kebiasaan Belajar (Studi Habit)</h1>
                    <p class="text-sm text-white/80 mt-1">Kenali pola dan kebiasaan belajarmu serta gaya belajar dominan yang dimiliki.</p>
                </div>

                {{-- ISI KARTU --}}
                <div class="p-8 bg-[#F4F1FF]">

                    {{-- INSTRUKSI SESUAI GAMBAR ATTACHMENT --}}
                    <div class="space-y-4">

                        {{-- Petunjuk Umum --}}
                        <div class="bg-[#E9ECF5] rounded-xl p-5">
                            <h3 class="font-semibold text-[#0A2A43]">Petunjuk Umum</h3>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                Angket ini bertujuan untuk mengetahui kebiasaan belajar (studi habit) serta gaya belajar dominan yang dimiliki oleh siswa. Informasi ini akan digunakan untuk membantu guru bimbingan dan konseling serta guru mata pelajaran dalam memberikan layanan yang sesuai dengan kebutuhan belajar siswa.
                            </p>
                        </div>

                        {{-- Instruksi Pengisian --}}
                        <div class="bg-[#E9ECF5] rounded-xl p-5">
                            <h3 class="font-semibold text-[#0A2A43]">Instruksi Pengisian</h3>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                Isilah setiap pernyataan sesuai dengan kondisi dan kebiasaan pribadi Anda selama belajar, baik di sekolah maupun di rumah. Tidak ada jawaban benar atau salah. Kejujuran dalam mengisi angket ini sangat penting agar hasil yang diperoleh benar-benar mencerminkan diri Anda.
                            </p>
                        </div>

                        {{-- SKALA PENILAIAN --}}
                        <div class="mt-4 bg-white rounded-lg p-4 border border-gray-200">
                            <h4 class="font-medium text-gray-700 mb-3">Skala Penilaian</h4>
                            <p class="text-gray-600 text-sm mb-4">Berikan penilaian terhadap setiap pernyataan dengan memilih salah satu angka berikut:</p>

                            <ul class="grid grid-cols-1 sm:grid-cols-5 gap-3 text-center w-full">
                                <li class="px-3 py-2 rounded-md bg-[#FFF7F7] border border-red-100">
                                    <span class="block font-semibold text-sm text-red-700">Tidak Pernah</span>
                                    <span class="text-xs text-gray-500">(1)</span>
                                </li>

                                <li class="px-3 py-2 rounded-md bg-[#FFF8F0] border border-orange-100">
                                    <span class="block font-semibold text-sm text-orange-700">Jarang</span>
                                    <span class="text-xs text-gray-500">(2)</span>
                                </li>

                                <li class="px-3 py-2 rounded-md bg-[#F4F6F8] border border-gray-100">
                                    <span class="block font-semibold text-sm text-gray-700">Kadang-kadang</span>
                                    <span class="text-xs text-gray-500">(3)</span>
                                </li>

                                <li class="px-3 py-2 rounded-md bg-[#FFFBF0] border border-amber-100">
                                    <span class="block font-semibold text-sm text-amber-700">Sering</span>
                                    <span class="text-xs text-gray-500">(4)</span>
                                </li>

                                <li class="px-3 py-2 rounded-md bg-[#F2FFF5] border border-green-100">
                                    <span class="block font-semibold text-sm text-green-700">Selalu</span>
                                    <span class="text-xs text-gray-500">(5)</span>
                                </li>
                            </ul>
                        </div>

                    </div>

                    {{-- CHECKBOX PERSETUJUAN --}}
                    <div class="mt-8">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 rounded border-gray-400" id="agreement">
                            <span class="text-gray-700 text-sm">
                                Saya telah membaca petunjuk dan siap mengerjakan tes ini dengan jujur sesuai kondisi saya saat ini.
                            </span>
                        </label>
                    </div>

                    {{-- TOMBOL MULAI --}}
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('studi_habit.form') }}" onclick="if(!document.getElementById('agreement').checked){alert('Silakan centang persetujuan terlebih dahulu.'); return false;}"
                            class="bg-[#FFE27A] text-[#0A2A43] font-bold px-10 py-3 rounded-xl shadow-md hover:bg-yellow-400 transition">
                                Mulai
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>

</body>
</html>
