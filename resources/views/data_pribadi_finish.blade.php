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
    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: PROFIL UTAMA --}}
            <div class="lg:col-span-1 flex flex-col gap-6 animate-fade-in-up">

                <div class="bg-white shadow-xl rounded-2xl p-6 text-center border-t-8 border-[#FFE27A] relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-bl-lg">
                        Tersimpan
                    </div>

                    <div class="w-32 h-32 mx-auto bg-gray-200 rounded-full p-1 border-4 border-[#0A2A43] overflow-hidden mb-4 shadow-lg">
                        @if(isset($dataSiswa) && $dataSiswa->foto_profil)
                            <img src="{{ asset('storage/' . $dataSiswa->foto_profil) }}" class="w-full h-full object-cover rounded-full">
                        @elseif(Auth::check() && Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-gray-400">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-[#0A2A43] mb-1">{{ Auth::user()->name ?? 'Nama Siswa' }}</h2>
                    <p class="text-gray-500 text-sm font-medium mb-4">{{ Auth::user()->email ?? 'email@sekolah.com' }}</p>

                    <div class="bg-[#F4F1FF] rounded-lg p-4 text-left space-y-2 border border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jenis Kelamin:</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Agama:</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->agama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">TTL:</span>
                            <span class="font-semibold text-[#0A2A43] text-right">
                                {{ $dataSiswa->tempat_lahir ?? '-' }}, <br>
                                {{ isset($dataSiswa->tanggal_lahir) ? \Carbon\Carbon::parse($dataSiswa->tanggal_lahir)->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">No HP:</span>
                            <span class="font-semibold text-[#0A2A43]">{{ $dataSiswa->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0A2A43] text-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-sm uppercase tracking-widest text-gray-300 mb-4 border-b border-white/20 pb-2">Ringkasan Keluarga</h3>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <span class="block text-xs text-gray-400">Anak Ke</span>
                            <span class="text-2xl font-bold text-[#FFE27A]">{{ $dataSiswa->anak_ke ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Jml Saudara</span>
                            <span class="text-2xl font-bold text-[#FFE27A]">{{ $dataSiswa->jumlah_saudara ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20 text-center">
                        <span class="block text-xs text-gray-400">Status Anak</span>
                        <span class="font-semibold text-white">{{ $dataSiswa->status_anak ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL DATA --}}
            <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl p-8 animate-fade-in-up flex flex-col h-fit" style="animation-delay: 0.2s;">

                <div class="flex items-center justify-between mb-6 border-b pb-4">
                    <h3 class="text-xl font-bold text-[#0A2A43] flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rincian Data Pribadi
                    </h3>
                    <a href="{{ route('tes.saya') }}" class="bg-[#0A2A43] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#153e5e] transition flex items-center gap-2">
                        Kembali ke Tes Saya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <div class="space-y-8 custom-scroll overflow-y-auto pr-2" style="max-height: 700px;">

                    {{-- BAGIAN 1: Data Diri Lanjutan --}}
                    <section>
                        <h4 class="text-sm font-bold text-gray-500 uppercase mb-3 tracking-wide">Informasi Personal & Hobi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Alamat Rumah</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->alamat ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Status Rumah</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->kepemilikan_rumah ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2 bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Hobi</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->hobi ?? '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                                <span class="text-xs text-green-700 block font-bold">Kelebihan</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->kelebihan ?? '-' }}</p>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg border border-red-100">
                                <span class="text-xs text-red-700 block font-bold">Kelemahan</span>
                                <p class="text-gray-800 font-medium text-sm">{{ $dataSiswa->kelemahan ?? '-' }}</p>
                            </div>
                        </div>
                    </section>

                    <hr class="border-dashed">

                    {{-- BAGIAN 2: Data Orang Tua --}}
                    <section>
                        <h4 class="text-sm font-bold text-gray-500 uppercase mb-3 tracking-wide">Data Orang Tua</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- AYAH --}}
                            <div class="border rounded-xl p-4 relative">
                                <span class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-blue-600">AYAH</span>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between"><span class="text-gray-500">Nama:</span> <span class="font-semibold">{{ $dataSiswa->nama_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Status:</span> <span>{{ $dataSiswa->status_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Pendidikan:</span> <span>{{ $dataSiswa->pendidikan_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Pekerjaan:</span> <span>{{ $dataSiswa->pekerjaan_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Gaji:</span> <span>{{ $dataSiswa->gaji_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Alamat:</span> <span>{{ $dataSiswa->alamat_ayah ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">No hp:</span> <span>{{ $dataSiswa->no_hp_ayah ?? '-' }}</span></div>
                                </div>
                            </div>
                            {{-- IBU --}}
                            <div class="border rounded-xl p-4 relative">
                                <span class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-pink-600">IBU</span>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between"><span class="text-gray-500">Nama:</span> <span class="font-semibold">{{ $dataSiswa->nama_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Status:</span> <span>{{ $dataSiswa->status_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Pendidikan:</span> <span>{{ $dataSiswa->pendidikan_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Pekerjaan:</span> <span>{{ $dataSiswa->pekerjaan_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Gaji:</span> <span>{{ $dataSiswa->gaji_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Alamat:</span> <span>{{ $dataSiswa->alamat_ibu ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">No hp:</span> <span>{{ $dataSiswa->no_hp_ibu ?? '-' }}</span></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <hr class="border-dashed">

                    {{-- BAGIAN 3: Data Ekonomi --}}
                    <section>
                        <h4 class="text-sm font-bold text-gray-500 uppercase mb-3 tracking-wide">Data Ekonomi</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-xl">
                                <span class="text-xs text-gray-500 block">Uang Saku</span>
                                <span class="font-bold text-[#0A2A43]">{{ $dataSiswa->uang_saku ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Bantuan Pemerintah</span>
                                <span class="font-bold text-[#0A2A43]">
                                    @if(is_array($dataSiswa->bantuan_pemerintah) && count($dataSiswa->bantuan_pemerintah) > 0)
                                        {{-- Gabungkan array menjadi string dipisah koma --}}
                                        {{ implode(', ', $dataSiswa->bantuan_pemerintah) }}
                                    @else
                                        {{-- Jika null atau bukan array --}}
                                        {{ $dataSiswa->bantuan_pemerintah ?? 'Tidak Ada' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </section>

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
