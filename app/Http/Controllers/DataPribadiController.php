<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaData; // Pastikan Model SiswaData di-import

class DataPribadiController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Mengecek apakah user sudah mengisi data pribadi secara lengkap.
     */
    public function instruksi()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Apakah user ini sudah ada datanya?
        $sudahLengkap = SiswaData::where('user_id', $user->id)->exists();

        // 2. LOGIKA PENGALIHAN
        if ($sudahLengkap) {
            // JIKA SUDAH: Tampilkan view Finish (Selesai)
            return view('data_pribadi_finish', compact('user'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi
        return view('data_pribadi', compact('user'));
    }

    /**
     * FORM STEP 1: DATA DIRI
     */
    public function form()
    {
        $user = Auth::user();

        // PROTEKSI: Jika user sudah selesai, tendang balik ke instruksi (yang akan menampilkan finish)
        if (SiswaData::where('user_id', $user->id)->exists()) {
             return redirect()->route('data_pribadi');
        }

        return view('data_pribadi_form', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 1
     */
    public function storeForm(Request $request)
    {
        // 1. Validasi Data Diri
        $validated = $request->validate([
            'kelas' => 'required',
            'nama_lengkap' => 'required',
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
            'bantuan_pemerintah' => 'nullable', // Array checkbox biasanya
            'foto_kartu_bantuan' => 'nullable|image|max:2048',
            'alamat' => 'required',
            'kepemilikan_rumah' => 'required',
            'no_hp' => 'required',
            'hobi' => 'required',
            'kelebihan' => 'required',
            'kelemahan' => 'required',
        ]);

        // 2. Handle Upload File
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('uploads/profil', 'public');
            $validated['foto_profil_path'] = $path;
            unset($validated['foto_profil']);
        }

        if ($request->hasFile('foto_kartu_bantuan')) {
            $path = $request->file('foto_kartu_bantuan')->store('uploads/bantuan', 'public');
            $validated['foto_kartu_bantuan_path'] = $path;
            unset($validated['foto_kartu_bantuan']);
        }

        // 3. Simpan ke Session
        $request->session()->put('data_pribadi_form', $validated);

        // 4. Redirect ke Halaman 2
        return redirect()->route('data_pribadi.step2');
    }

    /**
     * FORM STEP 2: DATA ORANG TUA
     */
    public function step2()
    {
        $user = Auth::user();

        // PROTEKSI 1: Sudah selesai?
        if (SiswaData::where('user_id', $user->id)->exists()) {
             return redirect()->route('data_pribadi');
        }

        // PROTEKSI 2: Belum isi Step 1?
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form');
        }

        return view('data_pribadi_step2', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 2
     */
    public function storeStep2(Request $request)
    {
        // 1. Validasi Data Orang Tua
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
            'no_hp_ibu' => 'nullable',
        ]);

        // 2. Simpan Data Step 2 ke Session
        $request->session()->put('data_pribadi_step2', $validated);

        // 3. Redirect ke Halaman 3 (Data Wali)
        return redirect()->route('data_pribadi.step3');
    }

    /**
     * FORM STEP 3: DATA WALI
     */
    public function step3()
    {
        $user = Auth::user();

        // PROTEKSI 1: Sudah selesai?
        if (SiswaData::where('user_id', $user->id)->exists()) {
             return redirect()->route('data_pribadi');
        }

        // PROTEKSI 2: Belum isi Step 1 atau Step 2?
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form');
        }
        if (!session()->has('data_pribadi_step2')) {
            return redirect()->route('data_pribadi.step2');
        }

        return view('data_pribadi_step3', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 3 (FINAL)
     */
    public function storeStep3(Request $request)
    {
        // 1. Validasi Data Wali
        $validated = $request->validate([
            'nama_wali' => 'nullable|string',
            'alamat_wali' => 'nullable|string',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
        ]);

        // 2. Ambil Semua Data dari Session
        $step1 = session()->get('data_pribadi_form');
        $step2 = session()->get('data_pribadi_step2');
        $step3 = $validated;

        // 3. Gabungkan Semua Data
        $finalData = array_merge($step1, $step2, $step3);
        $finalData['user_id'] = Auth::id();

        // Handle JSON encode untuk bantuan pemerintah (checkbox array)
        if(isset($finalData['bantuan_pemerintah']) && is_array($finalData['bantuan_pemerintah'])){
             $finalData['bantuan_pemerintah'] = json_encode($finalData['bantuan_pemerintah']);
        }

        // 4. Simpan ke Database (FINAL)
        try {
            SiswaData::updateOrCreate(
                ['user_id' => Auth::id()],
                $finalData
            );

            // Hapus session setelah berhasil disimpan
            $request->session()->forget(['data_pribadi_form', 'data_pribadi_step2']);

            // 5. REDIRECT KE HALAMAN UTAMA (instruksi/index)
            // Di sana nanti akan otomatis dicek DB -> tampilkan Finish.
            return redirect()->route('data_pribadi');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Finish (Opsional, karena sudah dihandle di index/instruksi)
     */
    public function finish()
    {
        $user = Auth::user();
        return view('data_pribadi_finish', compact('user'));
    }
}
