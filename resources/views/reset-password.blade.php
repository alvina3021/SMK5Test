<!DOCTYPE html>
<html lang="id">
<head>
    <title>Atur Ulang Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#001F4C] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-2xl font-bold text-[#001F4C] mb-4 text-center">Buat Password Baru</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Gagal!</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $email ?? request()->email }}" readonly
                       class="w-full border p-3 rounded bg-gray-100 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required
                       class="w-full border p-3 rounded">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ketik ulang password" required
                       class="w-full border p-3 rounded">
            </div>

            <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-[#001F4C] font-bold py-3 rounded transition">
                Simpan Password Baru
            </button>
        </form>
    </div>

</body>
</html>