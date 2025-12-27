<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        {{-- LOGO / HEADER --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#0A2A43] mb-2">Lupa Password?</h1>
            <p class="text-gray-600">Masukkan email Anda untuk mendapatkan kode verifikasi</p>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            {{-- Alert Error --}}
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            {{-- Alert Success --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2A43] focus:border-transparent outline-none transition @error('email') border-red-500 @enderror" 
                           placeholder="nama@example.com"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-[#0A2A43] text-white font-bold py-3 px-6 rounded-lg hover:bg-[#143d5e] transition duration-200 shadow-lg">
                    Kirim Kode Verifikasi
                </button>
            </form>

            {{-- Back to Login --}}
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-[#0A2A43] hover:text-[#143d5e] font-semibold text-sm flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6 text-gray-500 text-sm">
            <p>Kode verifikasi akan dikirim ke email Anda</p>
        </div>
    </div>

</body>
</html>
