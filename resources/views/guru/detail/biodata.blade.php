<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa - Guru Area</title>
    {{-- Menggunakan Vite untuk CSS/JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">
    
    {{-- NAVBAR --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
            <span class="bg-white/20 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Guru Area</span>
        </div>
        {{-- Link Dashboard --}}
        <a href="{{ route('guru.dashboard') }}" class="text-white hover:text-[#FFE27A] font-semibold border-b-2 border-white pb-1">Dashboard</a>
    </nav>

    <main class="grow py-10 px-4">
        <div class="max-w-4xl mx-auto">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-[#0A2A43] mb-6 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                {{-- Header Card --}}
                <div class="bg-[#0A2A43] px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-white">Data Pribadi Siswa</h2>
                    {{-- Menampilkan Nama & Kelas (Safe Operator ??) --}}
                    <p class="text-blue-200 text-sm">{{ $siswa->name ?? $siswa->nama_lengkap }} ({{ $siswa->kelas ?? '-' }})</p>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-8">
                        
                        {{-- Bagian Foto Profil --}}
                        <div class="flex-shrink-0 text-center">
                            @if(isset($siswa->foto_profil_path) && $siswa->foto_profil_path)
                                <img src="{{ asset('public/app/public/'.$siswa->foto_profil_path) }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-sm mx-auto">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mx-auto text-4xl font-bold">
                                    {{ substr($siswa->name ?? 'S', 0, 1) }}
                                </div>
                            @endif
                            <div class="mt-4 text-sm font-semibold text-gray-500">NIS: {{ $siswa->nis ?? '-' }}</div>
                        </div>

                        {{-- Bagian Detail Biodata --}}
                        <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                            {{-- Kita loop array data agar kodingan lebih rapi --}}
                            @foreach([
                                'Tempat, Tgl Lahir' => ($siswa->tempat_lahir ?? '-') . ', ' . ($siswa->tanggal_lahir ?? '-'),
                                'Jenis Kelamin' => $siswa->jenis_kelamin ?? '-',
                                'Agama' => $siswa->agama ?? '-',
                                'No. HP' => $siswa->no_hp ?? '-',
                                'Alamat' => $siswa->alamat ?? '-',
                                'Hobi' => $siswa->hobi ?? '-',
                                'Nama Ayah' => $siswa->nama_ayah ?? '-',
                                'Nama Ibu' => $siswa->nama_ibu ?? '-',
                            ] as $label => $value)
                            <div class="border-b border-gray-100 pb-2">
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</span>
                                <span class="block text-gray-800 font-medium mt-1">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bagian Tambahan (Ekonomi) --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-[#0A2A43] mb-4">Data Tambahan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 font-bold uppercase">Kepemilikan Rumah</span>
                                <div class="font-semibold">{{ $siswa->kepemilikan_rumah ?? '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 font-bold uppercase">Uang Saku</span>
                                <div class="font-semibold">{{ $siswa->uang_saku ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright &copy; {{ date('Y') }} SMKN 5 Malang.
    </footer>
</body>
</html>