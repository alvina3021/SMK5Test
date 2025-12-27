@extends('layouts.app') 

@section('content')
<div class="max-w-4xl mx-auto py-6">
    {{-- Tombol Kembali --}}
    <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 mb-6 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-[#0A2A43] px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-white">Data Pribadi Siswa</h2>
            <p class="text-blue-200 text-sm">{{ $siswa->nama_lengkap }} ({{ $siswa->kelas }})</p>
        </div>

        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Foto Profil --}}
                <div class="flex-shrink-0 text-center">
                    @if($siswa->foto_profil_path)
                        <img src="{{ asset('public/app/public/'.$siswa->foto_profil_path) }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-sm mx-auto">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mx-auto text-4xl font-bold">
                            {{ substr($siswa->nama, 0, 1) }}
                        </div>
                    @endif
                    <div class="mt-4 text-sm font-semibold text-gray-500">NIS: {{ $siswa->nis ?? '-' }}</div>
                </div>

                {{-- Detail Data --}}
                <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    @php
                        $fields = [
                            'Tempat, Tgl Lahir' => $siswa->tempat_lahir . ', ' . $siswa->tanggal_lahir,
                            'Jenis Kelamin' => $siswa->jenis_kelamin,
                            'Agama' => $siswa->agama,
                            'No. HP' => $siswa->no_hp,
                            'Alamat' => $siswa->alamat,
                            'Hobi' => $siswa->hobi,
                            'Nama Ayah' => $siswa->nama_ayah,
                            'Pekerjaan Ayah' => $siswa->pekerjaan_ayah,
                            'Nama Ibu' => $siswa->nama_ibu,
                            'Pekerjaan Ibu' => $siswa->pekerjaan_ibu,
                        ];
                    @endphp

                    @foreach($fields as $label => $value)
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</span>
                        <span class="block text-gray-800 font-medium mt-1">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Bagian Tambahan --}}
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-lg font-bold text-[#0A2A43] mb-4">Kondisi Ekonomi & Bantuan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs text-gray-500 font-bold uppercase">Kepemilikan Rumah</span>
                        <div class="font-semibold">{{ $siswa->kepemilikan_rumah }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs text-gray-500 font-bold uppercase">Uang Saku</span>
                        <div class="font-semibold">{{ $siswa->uang_saku }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection