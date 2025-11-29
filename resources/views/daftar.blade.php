<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SMK5Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-blue font-sans antialiased min-h-screen flex flex-col items-center justify-center py-10 px-4">

    {{-- HEADER TEXT --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-white mb-3 tracking-wide">
            Buat Akun SMK5Test
        </h1>
        <p class="text-gray-300 text-sm md:text-base max-w-md mx-auto leading-relaxed">
            Daftar untuk mengakses tes minat, bakat, psikotes, dan layanan bimbingan BK.
        </p>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl p-8 md:p-10 w-full max-w-[600px] shadow-2xl">
        <form action="{{ route('daftar.store') }}" method="POST">
            @csrf

            {{-- INPUT NAMA LENGKAP --}}
            <div class="mb-5">
                <label for="name" class="block text-primary-blue font-bold text-sm mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 focus:outline-none focus:border-primary-blue focus:ring-1 focus:ring-primary-blue transition placeholder-gray-400"
                    placeholder="Isi nama sesuai ijazah / data sekolah">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- INPUT NIS --}}
            <div class="mb-5">
                <label for="nis" class="block text-primary-blue font-bold text-sm mb-2">NIS</label>
                <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                    class="w-full border @error('nis') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 focus:outline-none focus:border-primary-blue focus:ring-1 focus:ring-primary-blue transition placeholder-gray-400"
                    placeholder="Masukkan Nomor Induk Siswa">
                @error('nis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- INPUT EMAIL --}}
            <div class="mb-5">
                <label for="email" class="block text-primary-blue font-bold text-sm mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 focus:outline-none focus:border-primary-blue focus:ring-1 focus:ring-primary-blue transition placeholder-gray-400"
                    placeholder="Masukkan Alamat Email">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ROW KELAS & JURUSAN --}}
            <div class="flex flex-col md:flex-row gap-5 mb-5">
                {{-- KELAS --}}
                <div class="w-full md:w-1/2">
                    <label for="kelas" class="block text-primary-blue font-bold text-sm mb-2">Kelas</label>
                    <div class="relative">
                        <select id="kelas" name="kelas" class="w-full border @error('kelas') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 appearance-none focus:outline-none focus:border-primary-blue bg-white">
                            <option value="" disabled selected>Pilih Kelas</option>
                            <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>X (10)</option>
                            <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>XI (11)</option>
                            <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>XII (12)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    @error('kelas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- JURUSAN --}}
                <div class="w-full md:w-1/2">
                    <label for="jurusan" class="block text-primary-blue font-bold text-sm mb-2">Jurusan</label>
                    <div class="relative">
                        <select id="jurusan" name="jurusan" class="w-full border @error('jurusan') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 appearance-none focus:outline-none focus:border-primary-blue bg-white">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                            <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="DKV" {{ old('jurusan') == 'DKV' ? 'selected' : '' }}>DKV</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    @error('jurusan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- INPUT PASSWORD --}}
            <div class="mb-6">
                <label for="password" class="block text-primary-blue font-bold text-sm mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 focus:outline-none focus:border-primary-blue focus:ring-1 focus:ring-primary-blue transition placeholder-gray-400"
                    placeholder="Minimal 6 Karakter">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- INGAT SAYA & LUPA PASSWORD --}}
            <div class="flex justify-between items-center mb-8 text-sm text-gray-600">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" class="form-checkbox h-4 w-4 text-primary-blue border-gray-300 rounded focus:ring-primary-blue">
                    <span class="ml-2">Ingat Saya</span>
                </label>
                <a href="#" class="text-primary-blue hover:underline font-medium">Lupa password?</a>
            </div>

            {{-- TOMBOL DAFTAR --}}
            <button type="submit" class="w-full bg-secondary-yellow text-primary-blue font-serif font-bold text-xl py-4 rounded-lg shadow-md hover:bg-yellow-400 transition duration-200">
                Daftar Sekarang
            </button>
        </form>
    </div>

    {{-- FOOTER BAWAH --}}
    <div class="mt-10 text-center text-white text-sm space-y-2">
        <p>Terintegrasi dengan SIAKAD SMKN 5 Malang</p>
        <p>Butuh bantuan? <a href="#" class="text-blue-300 hover:text-white underline transition">Hubungi Admin</a></p>
    </div>

</body>
</html>
