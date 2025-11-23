<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaya Belajar - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .custom-radio input[type="radio"]:checked + div { border-color: #0A2A43; background-color: #eef2ff; }
        .custom-radio input[type="radio"]:checked + div .radio-circle { border-color: #0A2A43; border-width: 5px; }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">

    {{-- HEADER / NAVIGATION BAR --}}
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
                <div class="text-[#0A2A43] font-bold text-lg">Gaya Belajar Anda</div>
                <div class="text-gray-500 font-semibold">B. Gaya Belajar (Visual, Auditori, Kinestik)</div>
            </div>

            <form action="{{ route('studi_habit.store_step2') }}" method="POST" class="bg-white shadow-xl rounded-xl p-8 space-y-8">
                @csrf

                {{-- ==================== VISUAL ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                    <p class="font-bold text-[#0A2A43]">VISUAL</p>
                    <p class="text-sm text-gray-600">Pertanyaan untuk mengidentifikasi gaya belajar visual Anda.</p>
                </div>

                {{-- Pertanyaan 1: Visual --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya lebih mudah memahami pelajaran melalui gambar atau diagram. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="visual_1" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 2: Visual --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya suka mencatat dengan warna atau simbol. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="visual_2" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 3: Visual --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya suka melihat guru menulis di papan tulis. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="visual_3" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 4: Visual --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya suka menggunakan video pembelajaran. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="visual_4" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ==================== AUDITORI ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <p class="font-bold text-[#0A2A43]">AUDITORI</p>
                    <p class="text-sm text-gray-600">Pertanyaan untuk mengidentifikasi gaya belajar auditori Anda.</p>
                </div>

                {{-- Pertanyaan 1: Auditori --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya lebih mudah memahami pelajaran jika dijelaskan secara lisan. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="auditori_1" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 2: Auditori --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya suka berdiskusi untuk memahami pelajaran. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="auditori_2" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 3: Auditori --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya suka mendengarkan rekaman suara atau audio belajar. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="auditori_3" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ==================== KINESTIK ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <p class="font-bold text-[#0A2A43]">KINESTIK</p>
                    <p class="text-sm text-gray-600">Pertanyaan untuk mengidentifikasi gaya belajar kinestik Anda.</p>
                </div>

                {{-- Pertanyaan 1: Kinestik --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <label class="block text-lg font-bold text-gray-800">Saya bisa mengingat informasi dengan cara mengucapkannya berulang. *</label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Sangat Tidak sesuai', 'Tidak sesuai', 'Netral', 'Sesuai', 'Sangat sesuai'] as $option)
                        <label class="cursor-pointer block">
                            <input type="radio" name="kinestik_1" value="{{ $option }}" class="hidden" required>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $option }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- NAVIGASI BUTTONS --}}
                <div class="mt-10 flex justify-between gap-4">
                    <a href="{{ route('studi_habit.form') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" class="w-2/3 bg-[#0A2A43] text-white font-bold text-lg py-3 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200">
                        Selesai
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
