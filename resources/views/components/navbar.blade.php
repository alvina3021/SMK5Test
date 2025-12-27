<nav class="bg-[#0A2A43] text-white px-4 md:px-10 py-4 shadow-lg sticky top-0 z-20">
    <div class="flex items-center justify-between">
        {{-- Logo & Menu (Kiri) --}}
        <div class="flex items-center gap-6">
            {{-- Burger Menu (Mobile Only) --}}
            <button onclick="toggleMenu()" class="sm:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo --}}
            <span class="text-xl font-serif font-bold">SMK5TEST</span>

            {{-- Menu Desktop & Tablet --}}
            <ul class="hidden sm:flex gap-6 text-white/80 font-semibold">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="hover:text-[#FFE27A] pb-1 border-b-2 transition {{ request()->routeIs('dashboard') ? 'text-white border-white' : 'border-transparent' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('tes.saya') }}" 
                       class="hover:text-[#FFE27A] pb-1 border-b-2 transition {{ request()->routeIs('tes.saya') ? 'text-white border-white' : 'border-transparent' }}">
                        Tes Saya
                    </a>
                </li>
            </ul>
        </div>

        {{-- Profil (Kanan) --}}
        @auth
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 hover:opacity-90 transition group">
            <span class="text-white text-base font-semibold hidden md:block group-hover:text-[#FFE27A] transition">
                {{ explode(' ', $user->name)[0] }}
            </span>
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer overflow-hidden border-2 border-transparent group-hover:border-[#FFE27A] transition">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </div>
    
    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden sm:hidden mt-4 pb-2">
        <ul class="flex flex-col gap-3">
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="block py-2 px-4 rounded hover:bg-white/10 transition {{ request()->routeIs('dashboard') ? 'bg-white/10' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('tes.saya') }}" 
                   class="block py-2 px-4 rounded hover:bg-white/10 transition {{ request()->routeIs('tes.saya') ? 'bg-white/10' : '' }}">
                    Tes Saya
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    }
</script>
