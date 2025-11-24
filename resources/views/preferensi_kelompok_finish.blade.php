<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesai - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Animasi kustom untuk ikon sukses */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(5%); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Materi</a></li>
        </ul>

        {{-- PROFIL --}}
        @auth
        <div class="flex items-center gap-3 ml-auto">
            <span class="text-white text-base font-semibold hidden sm:block">{{ explode(' ', $user->name)[0] }}</span>
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer">
                {{ substr(explode(' ', $user->name)[0], 0, 1) }}
            </div>
        </div>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="grow flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg mx-auto">

            {{-- KARTU SUKSES --}}
            <div class="bg-white shadow-2xl rounded-2xl p-8 md:p-12 text-center relative overflow-hidden border-t-8 border-[#0A2A43]">

                {{-- Hiasan Garis Kuning --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-[#FFE27A]"></div>

                {{-- Ikon Sukses Animasi --}}
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-50 mb-6 animate-bounce-slow ring-8 ring-green-100/50">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                {{-- Judul --}}
                <h2 class="text-3xl font-bold text-[#0A2A43] mb-3">Terima Kasih!</h2>
                <h3 class="text-lg font-semibold text-gray-700 mb-6">Jawaban Anda Berhasil Disimpan</h3>

                {{-- Pesan --}}
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Anda telah menyelesaikan Tes Preferensi Kelompok dan Kebutuhan Sosial.<br>
                    Sistem kami sedang menganalisis jawaban Anda untuk menentukan preferensi kelompok dan kebutuhan sosial yang paling sesuai dengan Anda.
                </p>

                {{-- Tombol Kembali --}}
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-[#0A2A43] text-white font-bold text-base py-3 px-8 rounded-xl shadow-lg hover:bg-[#143d5e] hover:shadow-xl transform hover:-translate-y-1 transition duration-200 w-full sm:w-auto">
                    <span>Kembali ke Dashboard</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>

            </div>

            {{-- Informasi Tambahan Kecil --}}
            <p class="text-center text-gray-400 text-xs mt-6">
                Hasil tes dapat dilihat pada menu "Riwayat Tes" di dashboard Anda.
            </p>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>

</body>
</html>
