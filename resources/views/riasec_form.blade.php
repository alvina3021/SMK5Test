<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir RIASEC - SMK5TEST</title>
    {{-- Pastikan Vite sudah terload --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio agar mirip Google Form */
        .custom-radio-input:checked + div {
            border-color: #652D90; /* Warna Ungu Utama */
            background-color: #f3e8ff;
        }
        .custom-radio-input:checked + div .radio-inner {
            background-color: #652D90;
            transform: scale(1);
        }
        /* Hover effects */
        .radio-option:hover div {
            border-color: #652D90;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- 1. DATA SOAL LENGKAP (Diambil dari gambar yang diunggah) --}}
    @php
        $sections = [
            'Realistic (R)' => [
                'Menanam atau merawat tanaman',
                'Mengemudi kendaraan proyek atau alat berat',
                'Menggunakan alat-alat teknik',
                'Membangun atau memperbaiki bangunan',
                'Menggunakan alat ukur dan peralatan mekanik',
                'Melakukan pekerjaan fisik berat',
                'Bekerja di bengkel atau laboratorium teknik'
            ],
            'Investigative (I)' => [
                'Melakukan eksperimen atau penelitian ilmiah',
                'Menganalisis grafik, data, atau angka',
                'Membaca artikel sains atau teknologi',
                'Memecahkan soal matematika atau logika',
                'Meneliti masalah dan mencari solusi logis',
                'Mengevaluasi data statistik',
                'Membaca buku atau jurnal akademik',
                'Menggunakan komputer untuk menganalisis informasi',
                'Mengamati dan mencatat gejala atau kejadian ilmiah',
                'Mengidentifikasi pola dari informasi yang kompleks'
            ],
            'Artistic (A)' => [
                'Membuat konten video atau animasi',
                'Mengedit foto atau video secara kreatif',
                'Membuat karya seni dari bahan bekas atau alam',
                'Bermain alat musik atau menyanyi',
                'Mendesain poster, logo, atau produk kreatif',
                'Menata dekorasi ruangan atau panggung',
                'Menari atau menampilkan pertunjukan',
                'Menata busana atau gaya penampilan',
                'Menggambar, melukis, atau membuat ilustrasi',
                'Menulis cerita, puisi, atau lagu'
            ],
            'Social (S)' => [
                'Menjadi relawan dalam kegiatan sosial',
                'Menolong teman menyelesaikan masalah pribadi',
                'Melayani orang dengan sabar dan empati',
                'Mengikuti kegiatan bakti sosial atau pengabdian masyarakat',
                'Mengajarkan sesuatu kepada orang lain',
                'Menjadi pendengar yang baik bagi orang lain',
                'Mendukung teman yang sedang kesulitan',
                'Menjadi mentor atau pembimbing bagi junior',
                'Bekerja dalam kelompok untuk mencapai tujuan sosial',
                'Menjadi fasilitator dalam diskusi kelompok'
            ],
            'Enterprising (E)' => [
                'Membujuk orang lain untuk membeli sesuatu',
                'Memimpin diskusi atau kegiatan kelompok',
                'Membuat ide usaha atau bisnis kecil',
                'Menyampaikan pendapat dalam forum',
                'Menjual produk secara langsung atau daring',
                'Mengatur strategi promosi atau pemasaran',
                'Memimpin proyek atau kegiatan organisasi',
                'Bernegosiasi atau berdiskusi untuk kesepakatan',
                'Mempengaruhi orang lain agar mengikuti gagasan',
                'Mencari peluang dan tantangan baru'
            ],
            'Conventional (C)' => [
                'Mengisi atau memeriksa data dalam tabel',
                'Mengarsip dokumen atau file secara rapi',
                'Mengatur jadwal kegiatan atau pertemuan',
                'Membuat laporan tertulis secara rinci',
                'Memasukkan data ke dalam komputer',
                'Menyusun anggaran atau laporan keuangan',
                'Memeriksa catatan transaksi atau dokumen',
                'Mengorganisasi tugas secara sistematis',
                'Mengikuti prosedur atau instruksi dengan teliti',
                'Menggunakan software pengolah angka atau kata'
            ]
            // Catatan: Kategori 'Conventional (C)' belum ada di gambar,
            // jika ada, silakan tambahkan di bawah array ini.
        ];
    @endphp

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
                    <img src="{{ asset('public/app/public/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">
            <form action="{{ route('riasec.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Minat RIASEC</h1>
                        <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Perencanaan Karir
                    </div>
                </div>

                {{-- BAGIAN 2: PERTANYAAN (LOOPING OTOMATIS BERDASARKAN ARRAY) --}}
                @foreach($sections as $categoryTitle => $questions)

                    {{-- Judul Kategori (Realistic, Investigative, Social, dll) --}}
                    <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $categoryTitle }}</h2>
                        </div>
                    </div>

                    @foreach($questions as $index => $question)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                        {{-- Soal --}}
                        <p class="text-gray-800 font-medium text-lg mb-6">{{ $question }}</p>

                        {{-- Skala 1-5 --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak suka</span>

                            <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                                @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    <input type="radio"
                                           {{-- Name dibuat unik: ans_social-s_0 --}}
                                           name="ans_{{ Str::slug($categoryTitle) }}_{{ $index }}"
                                           value="{{ $i }}"
                                           class="custom-radio-input sr-only"
                                           required>

                                    {{-- Custom Radio Circle --}}
                                    <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                        <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                    </div>
                                </label>
                                @endfor
                            </div>

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat suka</span>
                        </div>
                    </div>
                    @endforeach
                @endforeach


                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                     <a href="{{ route('riasec.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                     </a>

                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>

</body>
</html>
