<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Jawab AUM - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <main class="grow py-8 px-4 md:px-10">
        <div class="max-w-6xl mx-auto">

            <form action="{{ route('aum.storeStep1') }}" method="POST">
                @csrf

                {{-- HEADER STICKY --}}
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 sticky top-20 z-20 border-t-4 border-[#FFE27A]">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-[#0A2A43]">Langkah 1: Identifikasi Masalah</h2>
                            <p class="text-sm text-gray-600">Centang kotak pada nomor masalah yang sedang Anda alami saat ini.</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs text-gray-500 uppercase font-bold">Progress</span>
                            <span class="text-2xl font-bold text-[#0A2A43]" id="count-checked">0</span>
                            <span class="text-sm text-gray-500">masalah dipilih</span>
                        </div>
                    </div>
                </div>

                {{-- DAFTAR MASALAH (DATA DARI PDF) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($categories as $categoryCode => $items)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden col-span-1 md:col-span-2 lg:col-span-3 category-group"
                             data-code="{{ $categoryCode }}"> {{-- Tambahkan data-code di sini --}}

                            <div class="bg-[#E9ECF5] px-6 py-3 border-b border-gray-200">
                                {{-- Menampilkan Nama Kategori --}}
                                <h3 class="font-bold text-[#0A2A43]">
                                    {{ $categoryCode }}
                                    <span class="text-xs font-normal text-red-500 ml-2 hidden error-msg">
                                        (Wajib pilih minimal 1)
                                    </span>
                                </h3>
                            </div>

                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($items as $item)
                                    <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-[#F4F1FF] transition cursor-pointer border border-transparent hover:border-[#d8e4ff]">
                                        <div class="flex items-center h-5">
                                            {{-- Tambahkan class khusus 'cat-{code}' untuk validasi --}}
                                            <input type="checkbox" name="problems[]" value="{{ $item['id'] }}"
                                                class="problem-checkbox cat-{{ $categoryCode }} w-5 h-5 text-[#0A2A43] border-gray-300 rounded focus:ring-[#FFE27A]">
                                        </div>
                                        <div class="text-sm text-gray-700">
                                            <span class="font-bold text-[#0A2A43] mr-1">{{ $item['id'] }}.</span>
                                            {{ $item['text'] }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- FOOTER ACTION --}}
                <div class="mt-8 bg-white p-6 rounded-xl shadow-lg border-t border-gray-100">

                    {{-- Info Progress Kecil (Opsional, di atas tombol) --}}
                    <div class="text-sm text-gray-500 italic mb-4 text-center">
                        Pastikan tidak ada masalah yang terlewat sebelum melanjutkan.
                    </div>

                    {{-- CONTAINER TOMBOL SEJAJAR --}}
                    <div class="flex justify-between gap-4">

                        {{-- TOMBOL KEMBALI --}}
                        <a href="{{ route('aum.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200 flex items-center justify-center gap-2">
                            Kembali
                        </a>

                        {{-- TOMBOL SELANJUTNYA --}}
                        <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 flex items-center justify-center gap-2 text-center">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    {{-- SCRIPT VALIDASI --}}
    <script>
        // Hitung Progress
        const checkboxes = document.querySelectorAll('.problem-checkbox');
        const countSpan = document.getElementById('count-checked');
        checkboxes.forEach(box => {
            box.addEventListener('change', () => {
                countSpan.textContent = document.querySelectorAll('.problem-checkbox:checked').length;
            });
        });

        // FUNGSI VALIDASI UTAMA
        function validateAndSubmit() {
            let isValid = true;
            const categoryGroups = document.querySelectorAll('.category-group');

            categoryGroups.forEach(group => {
                const code = group.getAttribute('data-code');
                // Cek apakah ada checkbox yang dicentang dalam kategori ini
                const checked = group.querySelectorAll(`.cat-${code}:checked`).length;
                const errorMsg = group.querySelector('.error-msg');

                if (checked === 0) {
                    isValid = false;
                    errorMsg.classList.remove('hidden'); // Tampilkan pesan error
                    group.classList.add('border-red-500', 'border-2'); // Highlight kotak
                } else {
                    errorMsg.classList.add('hidden');
                    group.classList.remove('border-red-500', 'border-2');
                }
            });

            if (isValid) {
                // Jika semua aman, submit form manual
                document.querySelector('form').submit();
            } else {
                alert('Mohon pilih minimal 1 masalah dari setiap kategori yang ditandai merah.');
                // Scroll ke error pertama
                document.querySelector('.border-red-500').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    </script>

</body>
</html>
