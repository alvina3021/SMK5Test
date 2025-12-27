<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Identitas Siswa - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styling radio button agar mirip Google Form */
        .custom-radio input[type="radio"]:checked + div {
            border-color: #0A2A43;
            background-color: #eef2ff;
        }
        .custom-radio input[type="radio"]:checked + div .radio-circle {
            border-color: #0A2A43;
            border-width: 5px;
        }
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

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">

            {{-- HEADER --}}
            <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                <h1 class="text-2xl font-bold text-white mb-2">Identitas Peserta Didik</h1>
                <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                    Data Diri
                </div>
            </div>

            {{-- FORMULIR --}}
            {{-- Perbaiki nama route menjadi huruf kecil semua sesuai web.php --}}
                <form action="{{ route('data_pribadi.store_form') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-xl p-8 space-y-8">
                    @csrf  {{-- WAJIB ADA: Token keamanan untuk form POST --}}

                {{-- 1. UNGGAH FOTO --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 1</div>
                    <label class="block text-lg font-bold text-gray-800">Unggah Foto</label>
                    <p class="text-sm text-gray-500">Ketentuan: tampak depan - wajah harus terlihat jelas - foto terbaru (berseragam, tidak menggunakan masker/helm).</p>

                    {{-- LOGIKA PREVIEW: Jika data sudah ada di database/session --}}
                    @if(isset($dataSiswa->foto_profil) && $dataSiswa->foto_profil)
                        <div class="flex items-center gap-4 bg-green-50 p-3 rounded-lg border border-green-200 mb-2">
                            {{-- Tampilkan Thumbnail Foto Lama --}}
                            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#0A2A43]">
                                <img src="{{ asset('storage/' . $dataSiswa->foto_profil) }}" class="w-full h-full object-cover" alt="Foto Lama">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#0A2A43]">&#10003; Foto sudah tersimpan</p>
                                <p class="text-xs text-gray-600">Biarkan kosong jika tidak ingin mengganti foto.</p>
                            </div>
                        </div>
                    @endif

                    {{-- INPUT FILE --}}
                    {{-- Perhatikan bagian {{ ... ? '' : 'required' }} --}}
                    {{-- Jika foto SUDAH ada ($dataSiswa->foto_profil), maka TIDAK required. Jika BELUM ada, maka required. --}}
                    <input type="file" name="foto_profil" accept="image/*"
                        {{ (isset($dataSiswa->foto_profil) && $dataSiswa->foto_profil) ? '' : 'required' }}
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#E9ECF5] file:text-[#0A2A43] hover:file:bg-[#dce1f0]">
                </div>

                {{-- 2. JENIS KELAMIN --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 2</div>
                    <label class="block text-lg font-bold text-gray-800">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Laki-Laki', 'Perempuan'] as $jk)
                        <label class="cursor-pointer block">
                            <input type="radio" name="jenis_kelamin" value="{{ $jk }}" class="hidden" required
                            @checked(old('jenis_kelamin', $dataSiswa->jenis_kelamin ?? '') == $jk)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $jk }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 5. AGAMA --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 3</div>
                    <label class="block text-lg font-bold text-gray-800">Agama <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha', 'Aliran Kepercayaan lain'] as $agama)
                        <label class="cursor-pointer block">
                            <input type="radio" name="agama" value="{{ $agama }}" class="hidden" required
                                @checked(old('agama', $dataSiswa->agama ?? '') == $agama)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $agama }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 6. TEMPAT LAHIR --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 4</div>
                    <label class="block text-lg font-bold text-gray-800">Tempat lahir (Nama Kota / Kabupaten) <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $dataSiswa->tempat_lahir ?? '') }}"class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Tempat Lahir" required>
                </div>

                {{-- 7. TANGGAL LAHIR --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 5</div>
                    <label class="block text-lg font-bold text-gray-800">Tanggal lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $dataSiswa->tanggal_lahir ?? '') }}"class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-[#0A2A43] outline-none transition" required>
                </div>

                {{-- 8. STATUS ANAK --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 6</div>
                    <label class="block text-lg font-bold text-gray-800">Status anak <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Kandung', 'Angkat/ Adopsi'] as $status_anak)
                        <label class="cursor-pointer block">
                            <input type="radio" name="status_anak" value="{{ $status_anak }}" class="hidden" required
                                @checked(old('status_anak', $dataSiswa->status_anak ?? '') == $status_anak)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $status_anak }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 9. ANAK KE --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 7</div>
                    <label class="block text-lg font-bold text-gray-800">Anak ke... <span class="text-red-500">*</span></label>
                    <input type="number" name="anak_ke" value="{{ old('anak_ke', $dataSiswa->anak_ke ?? '') }}" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Isi dengan angka" required>
                </div>

                {{-- 10. JUMLAH SAUDARA --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 8</div>
                    <label class="block text-lg font-bold text-gray-800">Jumlah Saudara .... <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $dataSiswa->jumlah_saudara ?? '') }}"class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Isi dengan angka" required>
                </div>

                {{-- 11. STATUS ORANG TUA --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 9</div>
                    <label class="block text-lg font-bold text-gray-800">Status orang tua <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Lengkap', 'Cerai Hidup', 'Cerai Mati (Salah Satu Meninggal)', 'Keduanya Meninggal (Yatim Piatu)'] as $status_ortu)
                        <label class="cursor-pointer block">
                            <input type="radio" name="status_orang_tua" value="{{ $status_ortu }}" class="hidden" required
                                @checked(old('status_orang_tua', $dataSiswa->status_orang_tua ?? '') == $status_ortu)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $status_ortu }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 12. UANG SAKU --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 10</div>
                    <label class="block text-lg font-bold text-gray-800">Uang saku per hari <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['< 5.000,00', '5.000 - 10.000', '10.000 - 20.000', '20.000 - 30.000', '> 30.000'] as $uang)
                        <label class="cursor-pointer block">
                            <input type="radio" name="uang_saku" value="{{ $uang }}" class="hidden" required
                                @checked(old('uang_saku', $dataSiswa->uang_saku ?? '') == $uang)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $uang }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 13. BANTUAN PEMERINTAH --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 11</div>
                    <label class="block text-lg font-bold text-gray-800">Apakah anda atau keluarga termasuk penerima bantuan pemerintah berupa? <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['KIP (Kartu Indonesia Pintar)', 'PKH (Program Keluarga Harapan)', 'KIS (Kartu Indonesia Sehat)', 'Tidak menerima bantuan apapun', 'Lain - lain'] as $bantuan)
                        <label class="cursor-pointer block">
                            {{-- Menggunakan Radio karena gambar menunjukkan lingkaran (radio), meskipun secara logika bisa multiple --}}
                            <input type="radio" name="bantuan_pemerintah" value="{{ $bantuan }}" class="hidden" required
                                @checked(old('bantuan_pemerintah', $dataSiswa->bantuan_pemerintah ?? '') == $bantuan)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $bantuan }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 14. UPLOAD KARTU BANTUAN --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 12</div>
                    <label class="block text-lg font-bold text-gray-800">Jika anda memiliki kartu bantuan pemerintah, mohon foto dan upload</label>
                    <input type="file" name="foto_kartu_bantuan" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#E9ECF5] file:text-[#0A2A43] hover:file:bg-[#dce1f0]">
                </div>

                {{-- 15. ALAMAT --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 13</div>
                    <label class="block text-lg font-bold text-gray-800">Alamat/ tempat tinggal saat ini (tulis lengkap beserta RT/RW, dan kode pos) <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Alamat Lengkap" required>
                        {{ old('alamat', $dataSiswa->alamat ?? '') }}</textarea>
                </div>

                {{-- 16. STATUS KEPEMILIKAN RUMAH --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 14</div>
                    <label class="block text-lg font-bold text-gray-800">Status kepemilikan rumah <span class="text-red-500">*</span></label>
                    <div class="space-y-2 custom-radio">
                        @foreach (['Milik Sendiri (milik orang tua)', 'Kontrak / Sewa', 'Kost', 'Milik saudara', 'lain-lain'] as $rumah)
                        <label class="cursor-pointer block">
                            <input type="radio" name="kepemilikan_rumah" value="{{ $rumah }}" class="hidden" required
                                @checked(old('kepemilikan_rumah', $dataSiswa->kepemilikan_rumah ?? '') == $rumah)>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <div class="radio-circle w-5 h-5 border-2 border-gray-400 rounded-full mr-3 bg-white"></div>
                                <span class="text-gray-700">{{ $rumah }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 17. NO HP --}}
                <div class="space-y-3 border-b border-gray-100 pb-6">
                    <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 15</div>
                    <label class="block text-lg font-bold text-gray-800">No telp/ HP aktif <span class="text-red-500">*</span></label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', $dataSiswa->no_hp ?? '') }}"class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Contoh: 081234567890" required>
                </div>

                {{-- 18. HOBI SAYA --}}
                    <div class="space-y-3 border-b border-gray-100 pb-6">
                        <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 16</div>
                        <label class="block text-lg font-bold text-gray-800">Hobi saya <span class="text-red-500">*</span></label>
                        <textarea name="hobi" rows="2" class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition" placeholder="Tuliskan hobi Anda" required>{{ old('hobi', $dataSiswa->hobi ?? '') }}</textarea>
                    </div>

                    {{-- 19. KELEBIHAN SAYA --}}
                    <div class="space-y-3 border-b border-gray-100 pb-6">
                        <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 17</div>
                        <label class="block text-lg font-bold text-gray-800">Kelebihan saya <span class="text-red-500">*</span></label>
                        <textarea name="kelebihan" rows="2"
                                class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition"
                                placeholder="Tuliskan kelebihan Anda" required>{{ old('kelebihan', $dataSiswa->kelebihan ?? '') }}</textarea>
                    </div>

                    {{-- 20. KELEMAHAN SAYA --}}
                    <div class="space-y-3 border-b border-gray-100 pb-6">
                        <div class="bg-[#0A2A43] text-white px-4 py-2 rounded-lg inline-block font-bold text-sm">Pertanyaan 18</div>
                        <label class="block text-lg font-bold text-gray-800">Kelemahan saya <span class="text-red-500">*</span></label>
                        <textarea name="kelemahan" rows="2"
                                class="w-full border-b border-gray-300 focus:border-[#0A2A43] outline-none py-2 px-1 transition"
                                placeholder="Tuliskan kelemahan Anda" required>{{ old('kelemahan', $dataSiswa->kelemahan ?? '') }}</textarea>
                    </div>

                    {{-- TOMBOL NAVIGASI STEP 2 --}}
                    <div class="mt-10 flex justify-between gap-4">
                    {{-- Tombol Kembali: Mengarah ke Dashboard atau Instruksi --}}
                    <a href="{{ route('data_pribadi') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>

                    {{-- Tombol Selanjutnya: TYPE SUBMIT (Wajib untuk mengirim form) --}}
                    {{-- Tombol diganti menjadi BUTTON TYPE SUBMIT agar data dikirim ke storeForm dulu --}}
                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Selanjutnya
                    </button>
                </div>
                </div>
            </form>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
