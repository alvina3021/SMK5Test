<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferensi Kelompok - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio */
        .custom-radio-input:checked + div {
            border-color: #652D90;
            background-color: #f3e8ff;
        }
        .custom-radio-input:checked + div .radio-inner {
            background-color: #652D90;
            transform: scale(1);
        }
        .radio-option:hover div {
            border-color: #652D90;
        }

        /* Styling untuk checkbox button-style */
        .checkbox-button:has(input[type="checkbox"]:checked) {
            background-color: #652D90;
            border-color: #652D90;
            color: white;
        }
        .checkbox-button:has(input[type="checkbox"]:checked) span {
            color: white;
            font-weight: 600;
        }
        .checkbox-button:hover {
            border-color: #652D90;
            cursor: pointer;
        }

        /* Styling Likert Scale Button */
        .likert-option {
            padding: 1rem;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 100px;
            flex: 1;
            background-color: #f9fafb;
            color: #374151;
        }
        .likert-option:hover {
            border-color: #652D90;
            background-color: #f3f4f6;
        }
        .likert-option:has(input[type="checkbox"]:checked),
        .likert-option:has(input[type="radio"]:checked) {
            background-color: #652D90;
            border-color: #652D90;
            color: white;
            font-weight: 600;
        }

        /* Styling untuk box kecil (karakteristik) */
        .likert-option-small {
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
            background-color: #f9fafb;
            color: #374151;
        }
        .likert-option-small:hover {
            border-color: #652D90;
            background-color: #f3f4f6;
        }
        .likert-option-small:has(input[type="checkbox"]:checked) {
            background-color: #652D90;
            border-color: #652D90;
            color: white;
            font-weight: 600;
        }
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
        <div class="w-full max-w-4xl mx-auto">
            <form action="{{ route('preferensi_kelompok.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Preferensi Kelompok</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Kolaborasi dan Kebutuhan Sosial
                    </div>
                </div>

                {{-- ===== BAGIAN 1: PREFERENSI KERJA KELOMPOK ===== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">PREFERENSI KERJA KELOMPOK</h2>
                    </div>
                </div>

                {{-- SOAL 1: Preferensi Kerja Kelompok (Checkbox) --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-semibold text-lg mb-6">Aku lebih suka bekerja dalam kelompok yang:</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @php
                            $options = [
                                ['label' => 'Anggotanya aktif berdiskusi', 'color' => 'ts'],
                                ['label' => 'Pembagian tugasnya jelas dari awal', 'color' => 'ks'],
                                ['label' => 'Ada teman yang sudah aku kenal', 'color' => 's'],
                                ['label' => 'Bebas memilih topik proyek', 'color' => 'ss']
                            ];
                        @endphp
                        @foreach($options as $index => $opt)
                        <label class="likert-option {{ $opt['color'] }}">
                            <input type="checkbox"
                                   name="preferensi_kerja_soal1[]"
                                   value="{{ $opt['label'] }}"
                                   class="sr-only">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs font-bold uppercase">{{ $opt['label'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- SOAL 2: Peran dalam Kelompok (Radio Button) --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-semibold text-lg mb-6">Dalam kelompok, aku lebih suka peran sebagai:</p>

                    <div class="space-y-3">
                        @foreach([
                            'Ketua atau Koordinator (membagi tugas, mengingatkan deadline)' => 'ketua',
                            'Peneliti (mencari referensi, menganalisis data)' => 'peneliti',
                            'Kreator (mendesain presentasi, membuat produk)' => 'kreator',
                            'Mediator (menjaga kerjasama tim)' => 'mediator'
                        ] as $label => $value)
                        <label class="cursor-pointer flex items-center gap-3 p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition radio-option">
                            <input type="radio"
                                   name="preferensi_kerja_soal2"
                                   value="{{ $value }}"
                                   class="custom-radio-input sr-only"
                                   required>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-400 flex items-center justify-center transition-all">
                                <div class="radio-inner w-2.5 h-2.5 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                            </div>
                            <span class="text-gray-700 font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ===== BAGIAN 2: KEBUTUHAN SOSIAL (SKALA LIKERT 1-5) ===== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">KEBUTUHAN SOSIAL</h2>
                    </div>
                </div>

                {{-- Pertanyaan 1 --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-medium text-base mb-4">Aku mudah berteman dengan orang baru.</p>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>

                        <div class="flex items-center justify-center gap-3 sm:gap-6 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium">{{ $i }}</span>
                                <input type="radio"
                                       name="kebutuhan_sosial_1"
                                       value="{{ $i }}"
                                       class="custom-radio-input sr-only"
                                       required>

                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>

                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 2 --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-medium text-base mb-4">Aku senang membantu teman yang kesulitan memahami materi.</p>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>

                        <div class="flex items-center justify-center gap-3 sm:gap-6 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium">{{ $i }}</span>
                                <input type="radio"
                                       name="kebutuhan_sosial_2"
                                       value="{{ $i }}"
                                       class="custom-radio-input sr-only"
                                       required>

                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>

                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 3 --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-medium text-base mb-4">Aku butuh waktu lama untuk nyaman/adaptasi di kelompok.</p>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat sesuai</span>

                        <div class="flex items-center justify-center gap-3 sm:gap-6 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium">{{ $i }}</span>
                                <input type="radio"
                                       name="kebutuhan_sosial_3"
                                       value="{{ $i }}"
                                       class="custom-radio-input sr-only"
                                       required>

                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>

                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat tidak sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 4 --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-medium text-base mb-4">Aku ingin guru membantu mengenal teman sekelas.</p>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat sesuai</span>

                        <div class="flex items-center justify-center gap-3 sm:gap-6 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium">{{ $i }}</span>
                                <input type="radio"
                                       name="kebutuhan_sosial_4"
                                       value="{{ $i }}"
                                       class="custom-radio-input sr-only"
                                       required>

                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>

                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat tidak sesuai</span>
                    </div>
                </div>

                {{-- ===== BAGIAN 3: KARAKTERISTIK DIRI (CHECKBOX) ===== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">KARAKTERISTIK DIRI</h2>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-semibold text-lg mb-6">Aku adalah orang yang... (pilih maksimal 3):</p>

                    <div class="flex gap-3 flex-wrap">
                        @foreach([
                            'Suka mendengarkan',
                            'Cepat belajar hal baru',
                            'Terorganisir',
                            'Kreatif',
                            'Humoris'
                        ] as $option)
                        <label class="likert-option-small" style="flex: 0 1 calc(20% - 0.6rem);">
                            <input type="checkbox"
                                   name="karakteristik_diri[]"
                                   value="{{ $option }}"
                                   class="sr-only"
                                   onchange="checkMaxCharacteristics()">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-xs font-bold leading-tight">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ===== BAGIAN 4: KEBUTUHAN KHUSUS (CHECKBOX) ===== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">KEBUTUHAN KHUSUS</h2>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
                    <p class="text-gray-800 font-semibold text-lg mb-6">Aku ingin guru/guru BK membantu dalam:</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach([
                            'Menemukan teman dengan minat serupa',
                            'Mengatasi rasa canggung di kelas baru',
                            'Memahami cara kerja kelompok yang efektif',
                            'Tidak membutuhkan bantuan'
                        ] as $option)
                        <label class="likert-option">
                            <input type="checkbox"
                                   name="kebutuhan_khusus[]"
                                   value="{{ $option }}"
                                   class="sr-only">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-sm font-bold">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                    <a href="{{ route('preferensi_kelompok.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
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

    {{-- MODAL POPUP - LIMIT KARAKTERISTIK --}}
    <div id="modalBackdrop" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div id="limitModal" style="display: none;" class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-pulse">
            {{-- Icon Warning --}}
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Batas Maksimal Tercapai</h3>

            {{-- Message --}}
            <p class="text-gray-600 text-center mb-6">
                Anda hanya dapat memilih <span class="font-bold text-red-600">maksimal 3 karakteristik</span>. Silakan hapus salah satu pilihan jika ingin menambah pilihan baru.
            </p>

            {{-- Close Button --}}
            <button onclick="closeLimitModal()" class="w-full bg-[#652D90] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#5a1f7a] transition duration-200">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        function checkMaxCharacteristics() {
            const checkboxes = document.querySelectorAll('input[name="karakteristik_diri[]"]');
            const checked = Array.from(checkboxes).filter(cb => cb.checked).length;

            if (checked > 3) {
                // Batalkan perubahan terakhir (uncheck checkbox yang baru dipilih)
                event.target.checked = false;

                // Tampilkan modal popup
                showLimitModal();
            }
        }

        function showLimitModal() {
            const modal = document.getElementById('limitModal');
            const backdrop = document.getElementById('modalBackdrop');

            if (modal && backdrop) {
                backdrop.style.display = 'flex';
                modal.style.display = 'flex';

                // Auto close setelah 3 detik
                setTimeout(() => {
                    closeLimitModal();
                }, 3000);
            }
        }

        function closeLimitModal() {
            const modal = document.getElementById('limitModal');
            const backdrop = document.getElementById('modalBackdrop');

            if (modal && backdrop) {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
            }
        }
    </script>

</body>
</html>
