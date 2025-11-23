<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaData;

class DataPribadiController extends Controller
{
    public function instruksi()
    {
        $user = Auth::user();
        return view('data_pribadi', compact('user'));
    }

    public function form()
    {
        $user = Auth::user();
        return view('data_pribadi_form', compact('user'));
    }

    // --- STEP 1: DATA DIRI ---
    public function step1()
    {
        $user = Auth::user();
        return view('data_pribadi_form', compact('user'));
    }

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
            'bantuan_pemerintah' => 'nullable',
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

    // --- STEP 2: DATA ORANG TUA ---
    public function step2()
    {
        // Cek session step 1
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form');
        }

        $user = Auth::user();
        return view('data_pribadi_step2', compact('user'));
    }

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

        // 2. Simpan Data Step 2 ke Session (JANGAN simpan ke DB dulu)
        $request->session()->put('data_pribadi_step2', $validated);

        // 3. Redirect ke Halaman 3 (Data Wali)
        return redirect()->route('data_pribadi.step3');
    }

    // --- STEP 3: DATA WALI (Baru) ---
    public function step3()
    {
        // Cek jika step 1 atau step 2 belum diisi
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form');
        }
        if (!session()->has('data_pribadi_step2')) {
            return redirect()->route('data_pribadi.step2');
        }

        $user = Auth::user();
        return view('data_pribadi_step3', compact('user'));
    }

    public function storeStep3(Request $request)
    {
        // 1. Validasi Data Wali (Nullable semua karena opsional)
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

        // Handle JSON encode untuk bantuan pemerintah (dari Step 1)
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

            return redirect()->route('data_pribadi.finish');
            //return redirect()->route('dashboard')->with('success', 'Seluruh data berhasil disimpan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function finish()
    {
        $user = Auth::user();
        return view('data_pribadi_finish', compact('user'));
    }
}
