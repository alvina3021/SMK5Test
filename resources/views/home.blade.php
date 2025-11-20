<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK5Test - Temukan Potensi Terbaikmu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white min-h-screen flex flex-col">

    {{-- Header dengan Background #003366 --}}
    <header class="flex justify-between items-center px-12 py-4 border-b border-gray-100 bg-[#003366]">
        <div class="flex items-center space-x-8">
            {{-- LOGO: Warna diubah menjadi text-white (#FFFFFF) --}}
            <div class="text-xl md:text-2xl font-bold text-white">SMK5Test</div>

            <nav class="hidden md:flex space-x-6 text-base">
                {{-- LINK NAVIGASI: Warna diubah menjadi text-white (#FFFFFF) --}}
                {{-- Saya ubah hover-nya menjadi kuning/abu-terang agar tetap terlihat saat disorot --}}
                <a href="#" class="text-white hover:text-yellow-400 transition duration-150">Tentang</a>
                <a href="#" class="text-white hover:text-yellow-400 transition duration-150">Bantuan</a>
            </nav>
        </div>

        <div class="flex items-center space-x-3">
            {{-- Tombol Masuk juga sebaiknya putih agar serasi --}}
            <a href="{{ route('login') }}" class="text-white font-semibold text-lg px-4 py-2 hover:text-yellow-400 transition duration-150">Masuk</a>

            {{-- Tombol Daftar (Background Kuning, Teks Biru) --}}
            <a href="{{ route('daftar') }}" class="bg-secondary-yellow text-primary-blue font-bold text-lg px-4 py-2 rounded shadow-md hover:bg-yellow-500 transition duration-150">Daftar</a>
        </div>
    </header>

    <section class="bg-background-light min-h-screen flex items-center justify-center p-10">
        <div class="text-center w-full max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary-blue mb-10 leading-tight">
                Temukan Potensi Terbaikmu di SMK5Test
            </h1>

            <div class="max-w-3xl mx-auto bg-white p-10 md:p-14 rounded-3xl shadow-xl">
                <p class="text-xl text-gray-700 mb-10 leading-relaxed">
                    SMK5Test membantu siswa mengenali minat, bakat, kepribadian, dan arah karier masa depan.
                </p>
                <a href="{{ route('daftar') }}" class="inline-block bg-secondary-yellow text-primary-blue font-bold text-lg px-8 py-3 rounded-lg shadow-md hover:bg-yellow-500 transition duration-150">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-primary-blue text-white text-center py-6 px-4">
        <p class="text-sm mb-1">Terintegrasi dengan SIAKAD SMKN 5 Malang</p>
        <p class="text-sm">Butuh bantuan?
            <a href="#" class="text-secondary-yellow font-bold hover:text-yellow-300 transition duration-150 underline">Hubungi Admin</a>
        </p>
    </footer>

</body>
</html>
