<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Style untuk input kode OTP */
        .code-input {
            width: 3rem;
            height: 3.5rem;
            font-size: 1.5rem;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        {{-- LOGO / HEADER --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#0A2A43] mb-2">Verifikasi Kode</h1>
            <p class="text-gray-600">Masukkan kode 6 digit yang telah dikirim ke</p>
            <p class="font-bold text-[#0A2A43] mt-1">{{ session('email') }}</p>
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

            <form action="{{ route('password.verify') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">

                {{-- Kode Verifikasi --}}
                <div>
                    <label for="code" class="block text-sm font-bold text-gray-700 mb-3 text-center">Kode Verifikasi (6 Digit)</label>
                    <div class="flex justify-center gap-2 mb-4">
                        <input type="text" 
                               name="code" 
                               id="code"
                               maxlength="6"
                               class="code-input border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2A43] focus:border-transparent outline-none transition @error('code') border-red-500 @enderror" 
                               placeholder="000000"
                               required
                               autofocus>
                    </div>
                    @error('code')
                        <p class="text-sm text-red-600 text-center">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 text-center mt-2">Kode berlaku selama 15 menit</p>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-[#0A2A43] text-white font-bold py-3 px-6 rounded-lg hover:bg-[#143d5e] transition duration-200 shadow-lg">
                    Verifikasi Kode
                </button>
            </form>

            {{-- Resend Code --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 mb-2">Tidak menerima kode?</p>
                <a href="{{ route('password.request') }}" class="text-[#0A2A43] hover:text-[#143d5e] font-semibold text-sm">
                    Kirim Ulang Kode
                </a>
            </div>

            {{-- Back to Login --}}
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 text-sm flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>
