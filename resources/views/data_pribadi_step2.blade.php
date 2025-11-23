<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Orang Tua - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .custom-radio input[type="radio"]:checked + div { border-color: #0A2A43; background-color: #eef2ff; }
        .custom-radio input[type="radio"]:checked + div .radio-circle { border-color: #0A2A43; border-width: 5px; }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">

     {{-- HEADER / NAVIGATION BAR (Warna #0A2A43) --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
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

    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">

            {{-- Indikator Halaman --}}
            <div class="flex justify-between items-center mb-6">
                <div class="text-[#0A2A43] font-bold text-lg">Halaman 2 dari 2</div>
                <div class="text-gray-500 font-semibold">Data Orang Tua (Ayah)</div>
            </div>

            <form action="{{ route('data_pribadi.store_step2') }}" method="POST" class="bg-white shadow-xl rounded-xl p-8 space-y-8">
                @csrf

                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                    <p class="font-bold text-[#0A2A43]">DATA AYAH</p>
                    <p class="text-sm text-gray-600">Mohon lengkapi data ayah kandung/wali di bawah ini.</p>
                </div>

                {{-- 21. NAMA AYAH --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Nama Ayah *</label>
                    <input type="text" name="nama_ayah" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="Nama Lengkap Ayah" required>
                </div>

                {{-- 22. STATUS AYAH --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Status Ayah *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['ada / masih hidup', 'almarhum'] as $status)
                        <label class="cursor-pointer block">
                            <input type="radio" name="status_ayah" value="{{ $status }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700 capitalize">{{ $status }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 23. PENDIDIKAN TERAKHIR --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pendidikan Terakhir Ayah *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['SD', 'SMP', 'SMA/ SMK', 'Diploma', 'S1', 'S2', 'S3', 'Lain-lain'] as $pddk)
                        <label class="cursor-pointer block">
                            <input type="radio" name="pendidikan_ayah" value="{{ $pddk }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $pddk }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 24. PEKERJAAN --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="Wiraswasta, PNS, dll">
                </div>

                {{-- 25. GAJI --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Besar Gaji Ayah per Bulan *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['0', '< 500.000', '500.000 s.d 2.000.000', '2.000.000 s.d 3.500.000', '3.500.000 s.d 5.000.000', '> 5.000.000'] as $gaji)
                        <label class="cursor-pointer block">
                            <input type="radio" name="gaji_ayah" value="{{ $gaji }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $gaji }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 26. ALAMAT --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Alamat Ayah</label>
                    <textarea name="alamat_ayah" rows="2" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1"></textarea>
                </div>

                {{-- 27. NO HP --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">No. Telepon Ayah Aktif</label>
                    <input type="tel" name="no_hp_ayah" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="08xxx">
                </div>

                {{-- ==================== DATA IBU (Sesuai Gambar 4-9) ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <p class="font-bold text-[#0A2A43]">DATA IBU</p>
                    <p class="text-sm text-gray-600">Mohon lengkapi data ibu kandung di bawah ini.</p>
                </div>

                {{-- 28. NAMA IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Nama Ibu *</label>
                    <input type="text" name="nama_ibu" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="Nama Lengkap Ibu" required>
                </div>

                {{-- 29. STATUS IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Status Ibu *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['ada / masih hidup', 'almarhumah'] as $status)
                        <label class="cursor-pointer block">
                            <input type="radio" name="status_ibu" value="{{ $status }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700 capitalize">{{ $status }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 30. PENDIDIKAN TERAKHIR IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pendidikan Terakhir Ibu *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['SD', 'SMP', 'SMA/ SMK', 'Diploma', 'S1', 'S2', 'S3', 'Lain-lain'] as $pddk)
                        <label class="cursor-pointer block">
                            <input type="radio" name="pendidikan_ibu" value="{{ $pddk }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $pddk }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 31. PEKERJAAN IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="Wiraswasta, PNS, dll">
                </div>

                {{-- 32. GAJI IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Gaji Ibu Perbulan *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['0', '< 500.000', '500.000 s.d 2.000.000', '2.000.000 s.d 3.500.000', '3.500.000 s.d 5.000.000', '5.000.000 s.d 10.000.000', '> 10.000.000'] as $gaji)
                        <label class="cursor-pointer block">
                            <input type="radio" name="gaji_ibu" value="{{ $gaji }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $gaji }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 33. ALAMAT IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Alamat Ibu</label>
                    <textarea name="alamat_ibu" rows="2" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1"></textarea>
                </div>

                {{-- 34. NO HP IBU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">No. Telepon Ibu Aktif</label>
                    <input type="tel" name="no_hp_ibu" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1" placeholder="08xxx">
                </div>

                {{-- NAVIGASI BUTTONS --}}
                 <div class="mt-10 flex justify-between gap-4">
                    <a href="{{ route('data_pribadi.form') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" class="w-2/3 bg-[#0A2A43] text-white font-bold text-lg py-3 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200">
                        Selanjutnya
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
