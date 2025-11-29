<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- NAVBAR (Sama seperti Dashboard) --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
        </ul>

        {{-- Profil Kecil di Pojok Kanan --}}
        <div class="flex items-center gap-3 ml-auto">
            <span class="text-white text-base font-semibold hidden sm:block">{{ explode(' ', $user->name)[0] }}</span>
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer overflow-hidden">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{ substr($user->name, 0, 1) }}
                @endif
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-2xl">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                {{-- Header Card --}}
                <div class="bg-[#0A2A43] px-8 py-6 text-center">
                    <h1 class="text-2xl font-bold text-white">Profil Siswa</h1>
                    <p class="text-blue-200 text-sm mt-1">Informasi akun dan data akademik Anda</p>
                </div>

                <div class="p-8 md:p-10">

                    {{-- FOTO PROFIL & UPLOAD --}}
                    <div class="flex flex-col items-center mb-8">
                        <div class="relative group w-32 h-32">
                            {{-- Tampilan Foto --}}
                            <div class="w-32 h-32 rounded-full bg-gray-200 border-4 border-[#FFE27A] flex items-center justify-center overflow-hidden shadow-md">
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl font-bold text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>

                            {{-- Tombol Ganti Foto (Overlay) --}}
                            <label for="photo-upload" class="absolute bottom-0 right-0 bg-[#0A2A43] text-white p-2 rounded-full cursor-pointer hover:bg-blue-900 transition shadow-lg" title="Ganti Foto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                        </div>

                        {{-- Form Upload Tersembunyi --}}
                        <form id="photo-form" action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input type="file" id="photo-upload" name="photo" accept="image/*" onchange="document.getElementById('photo-form').submit();">
                        </form>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- INFORMASI DATA DIRI (READONLY) --}}
                    <div class="space-y-5">

                        <div>
                            <label class="block text-[#0A2A43] font-bold text-sm mb-2">Nama Lengkap</label>
                            <div class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[#0A2A43] font-bold text-sm mb-2">NIS</label>
                                <div class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3">
                                    {{ $user->nis ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-[#0A2A43] font-bold text-sm mb-2">Email</label>
                                <div class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[#0A2A43] font-bold text-sm mb-2">Kelas</label>
                                <div class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3">
                                    {{ $user->kelas ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-[#0A2A43] font-bold text-sm mb-2">Jurusan</label>
                                <div class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3">
                                    {{ $user->jurusan ?? '-' }}
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ACTION BUTTONS (DIUBAH) --}}
                    <div class="mt-10 flex justify-center"> {{-- Flex container untuk centering --}}

                        {{-- Tombol Kembali DIHAPUS --}}

                        {{-- Tombol Keluar (Merah) - Dibuat lebar penuh untuk mobile, tapi tetap di tengah --}}
                        <form action="{{ route('logout') }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-64 px-6 py-3 rounded-xl font-bold text-white bg-red-600 hover:bg-red-700 shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>
</body>
</html>
