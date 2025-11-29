<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaData;

class DataPribadiController extends Controller
{
    /**
     * Halaman Instruksi Awal
     * (Route: 'data_pribadi')
     */
    public function instruksi()
    {
        $user = Auth::user();
        // Cek apakah user sudah pernah mengisi data lengkap
        $dataSiswa = SiswaData::where('user_id', $user->id)->first();

        // Jika sudah lengkap, langsung tampilkan view finish
        if ($dataSiswa) {
            return view('data_pribadi_finish', compact('user', 'dataSiswa'));
        }
        return view('data_pribadi', compact('user'));
    }

    /**
     * LANGKAH 1: Form Data Diri
     */
    public function form()
    {
        $user = Auth::user();
        $dataSiswa = SiswaData::where('user_id', $user->id)->first();

        // Jika data belum ada di DB, cek apakah ada di session (sedang diisi)
        if (!$dataSiswa && session()->has('data_pribadi_form')) {
            $dataSiswa = new SiswaData(session('data_pribadi_form'));
        }

        return view('data_pribadi_form', compact('user', 'dataSiswa'));
    }

    /**
     * Simpan Langkah 1 ke Session
     */
    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'foto_profil' => 'nullable|image|max:2048',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'status_anak' => 'required',
            'anak_ke' => 'required',
            'jumlah_saudara' => 'required',
            'status_orang_tua' => 'required',
            'uang_saku' => 'required',
            'bantuan_pemerintah' => 'nullable',
            'foto_kartu_bantuan' => 'nullable|image|max:2048',
            'alamat' => 'required',
            'kepemilikan_rumah' => 'required',
            'no_hp' => 'required',
            'hobi' => 'required',
            'kelebihan' => 'required',
            'kelemahan' => 'required',
        ]);

        $user = Auth::user();
        // Inject data otomatis
        $validated['nama_lengkap'] = $user->name;
        $validated['kelas'] = $user->kelas ?? '-';

        // Handle File Upload
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('uploads/profil', 'public');
            $validated['foto_profil'] = $path;
        } elseif (session()->has('data_pribadi_form.foto_profil')) {
            $validated['foto_profil'] = session('data_pribadi_form.foto_profil');
        }

        if ($request->hasFile('foto_kartu_bantuan')) {
            $path = $request->file('foto_kartu_bantuan')->store('uploads/bantuan', 'public');
            $validated['foto_kartu_bantuan'] = $path;
        } elseif (session()->has('data_pribadi_form.foto_kartu_bantuan')) {
            $validated['foto_kartu_bantuan'] = session('data_pribadi_form.foto_kartu_bantuan');
        }

        // Simpan ke Session
        $request->session()->put('data_pribadi_form', $validated);

        return redirect()->route('data_pribadi.step2');
    }

    /**
     * LANGKAH 2: Data Orang Tua
     */
    public function step2()
    {
        $user = Auth::user();

        // Cek akses: harus ada session step 1 atau data di DB
        if (!session()->has('data_pribadi_form') && !SiswaData::where('user_id', $user->id)->exists()) {
            return redirect()->route('data_pribadi.form');
        }

        $dataSiswa = SiswaData::where('user_id', $user->id)->first();

        if (!$dataSiswa && session()->has('data_pribadi_step2')) {
            $dataSiswa = new SiswaData(session('data_pribadi_step2'));
        }

        return view('data_pribadi_step2', compact('user', 'dataSiswa'));
    }

    /**
     * Simpan Langkah 2 ke Session
     */
    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'nama_ayah' => 'required',
            'status_ayah' => 'required',
            'pendidikan_ayah' => 'required',
            'pekerjaan_ayah' => 'nullable',
            'gaji_ayah' => 'required',
            'alamat_ayah' => 'nullable',
            'no_hp_ayah' => 'nullable',
            'nama_ibu' => 'required',
            'status_ibu' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ibu' => 'nullable',
            'gaji_ibu' => 'required',
            'alamat_ibu' => 'nullable',
            // Pastikan ini match dengan database (no_hp_ibu)
            'no_hp_ibu' => 'nullable',
        ]);

        $request->session()->put('data_pribadi_step2', $validated);

        return redirect()->route('data_pribadi.step3');
    }

    /**
     * LANGKAH 3: Data Wali (Opsional)
     */
    public function step3()
    {
        $user = Auth::user();

        // Cek akses
        if (!session()->has('data_pribadi_step2') && !SiswaData::where('user_id', $user->id)->exists()) {
            return redirect()->route('data_pribadi.step2');
        }

        $dataSiswa = SiswaData::where('user_id', $user->id)->first();

        return view('data_pribadi_step3', compact('user', 'dataSiswa'));
    }

    /**
     * Simpan Langkah 3 & COMMIT KE DATABASE
     * (Versi Final: Debugging dihapus, JSON Constraint Fixed)
     */
    public function storeStep3(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_wali' => 'nullable|string',
            'alamat_wali' => 'nullable|string',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
        ]);

        // 2. Data Wali (Konversi string kosong jadi NULL)
        $dataWali = [
            'nama_wali'         => $request->nama_wali ?: null,
            'alamat_wali'       => $request->alamat_wali ?: null,
            'pendidikan_wali'   => $request->pendidikan_wali ?: null,
            'pekerjaan_wali'    => $request->pekerjaan_wali ?: null,
            'penghasilan_wali'  => $request->penghasilan_wali ?: null,
            'no_hp_wali'        => $request->no_hp_wali ?: null,
        ];

        // 3. Ambil Data Session
        $sessionStep1 = session()->get('data_pribadi_form', []);
        $sessionStep2 = session()->get('data_pribadi_step2', []);
        $existingData = SiswaData::where('user_id', Auth::id())->first();

        // 4. Cek Kelengkapan Data Session
        // Jika session habis dan bukan mode edit, kembalikan ke awal
        if (empty($sessionStep1) && !$existingData) {
             return redirect()->route('data_pribadi.form')
                 ->with('error', 'Sesi data pribadi habis. Mohon isi dari awal.');
        }

        // 5. Gabungkan Data (Merge)
        if ($existingData) {
            $baseData = $existingData->toArray();
            $finalData = array_merge($baseData, $sessionStep1, $sessionStep2, $dataWali);
        } else {
            $finalData = array_merge($sessionStep1, $sessionStep2, $dataWali);
        }

        // Pastikan User ID
        $finalData['user_id'] = Auth::id();

        // 6. Handle Array JSON (PERBAIKAN CONSTRAINT ERROR)
        // Kita wajib memastikan data ini menjadi NULL atau JSON Valid String.
        if (!empty($finalData['bantuan_pemerintah'])) {
             // Jika Array, encode jadi JSON
             if (is_array($finalData['bantuan_pemerintah'])) {
                 $finalData['bantuan_pemerintah'] = json_encode($finalData['bantuan_pemerintah']);
             }
             // Jika String tapi belum JSON valid (misal teks biasa), bungkus jadi JSON
             elseif (is_string($finalData['bantuan_pemerintah'])) {
                 // Cek apakah string ini valid JSON?
                 json_decode($finalData['bantuan_pemerintah']);
                 if (json_last_error() !== JSON_ERROR_NONE) {
                     // Jika error decode (bukan JSON), kita encode manual agar diterima DB
                     // Kita bungkus dalam array [] agar konsisten dengan format checkbox
                     $finalData['bantuan_pemerintah'] = json_encode([$finalData['bantuan_pemerintah']]);
                 }
             }
        } else {
             // Jika kosong, pastikan NULL explisit
             $finalData['bantuan_pemerintah'] = null;
        }

        try {
            // 7. Simpan ke Database
            SiswaData::updateOrCreate(
                ['user_id' => Auth::id()],
                $finalData
            );

            // 8. Hapus Session
            $request->session()->forget(['data_pribadi_form', 'data_pribadi_step2']);

            // 9. Redirect / Tampilkan View Finish
            // Kita bypass redirect untuk menghindari 404 jika route belum diset,
            // langsung tampilkan view finish dengan data terbaru.
            $dataSiswaFinal = SiswaData::where('user_id', Auth::id())->first();

            return view('data_pribadi_finish', [
                'user' => Auth::user(),
                'dataSiswa' => $dataSiswaFinal
            ]);

        } catch (\Exception $e) {
            // DEBUG MODE (Opsional: Matikan dd jika sudah fix, nyalakan jika ingin melihat error lain)
            // dd("DEBUG ERROR: " . $e->getMessage());

            // Kembalikan ke form dengan pesan error user friendly
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Halaman Finish (Ringkasan Data)
     */
    public function finish()
    {
        $user = Auth::user();
        $dataSiswa = SiswaData::where('user_id', $user->id)->first();

        if (!$dataSiswa) {
            return redirect()->route('data_pribadi.form');
        }

        return view('data_pribadi_finish', compact('user', 'dataSiswa'));
    }
}
