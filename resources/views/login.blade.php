<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SMK5Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#001F4C] font-sans antialiased min-h-screen flex flex-col items-center justify-center px-4">

    {{-- HEADER ATAS --}}
    <div class="text-center mb-8 text-white">
        <h1 class="text-3xl md:text-4xl font-serif font-bold tracking-wide mb-2">SMK5TEST</h1>
        <p class="text-sm md:text-base font-light text-gray-200">
            Sistem Tes Penjurusan & Karier untuk Siswa SMKN 5 Malang
        </p>
    </div>

    {{-- CARD FORM LOGIN --}}
    <div class="bg-white rounded-[2rem] p-8 md:p-10 w-full max-w-[500px] shadow-2xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-serif font-bold text-[#001F4C] mb-2">
                Selamat Datang! 👋
            </h2>
            <p class="text-gray-500 text-sm">
                Masuk menggunakan akun SIAKAD Anda untuk memulai
            </p>
        </div>

        <form action="{{ route('login.authenticate') }}" method="POST">
            @csrf

            {{-- INPUT USERNAME/NISN --}}
            <div class="mb-5">
                <input type="text" name="identity"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3.5 focus:outline-none focus:border-[#001F4C] focus:ring-1 focus:ring-[#001F4C] transition placeholder-gray-400"
                    placeholder="Masukkan NISN atau username" required>
            </div>

            {{-- INPUT PASSWORD --}}
            <div class="mb-6">
                <label for="password" class="block text-[#001F4C] font-bold text-base mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3.5 focus:outline-none focus:border-[#001F4C] focus:ring-1 focus:ring-[#001F4C] transition placeholder-gray-400"
                    placeholder="Masukkan Password" required>

                {{-- TAMBAHKAN INI: Untuk menampilkan pesan error login --}}
                @error('identity')
                    <p class="text-red-500 text-sm mt-2 italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- INGAT SAYA & LUPA PASSWORD --}}
            <div class="flex justify-between items-center mb-8 text-sm">
                <label class="flex items-center cursor-pointer text-gray-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-[#001F4C] border-gray-300 rounded focus:ring-[#001F4C]">
                    <span class="ml-2">Ingat Saya</span>
                </label>
                <a href="#" class="text-[#001F4C] font-semibold hover:underline">Lupa password?</a>
            </div>

            {{-- TOMBOL LOGIN --}}
            <button type="submit" class="w-full bg-[#FFD700] text-[#001F4C] font-serif font-bold text-2xl py-3.5 rounded-lg shadow-md hover:bg-yellow-400 transition duration-200 mb-6">
                Login
            </button>

            {{-- LINK KE DAFTAR --}}
            <div class="text-center text-sm md:text-base">
                <span class="text-black font-bold">Belum punya akun? </span>
                <a href="{{ route('daftar') }}" class="text-[#001F4C] font-bold hover:underline">Daftar</a>
            </div>
        </form>
    </div>

    {{-- FOOTER BAWAH --}}
    <div class="mt-10 text-center text-white text-sm">
        <p>Terintegrasi dengan SIAKAD SMKN 5 Malang</p>
    </div>

</body>
</html>
