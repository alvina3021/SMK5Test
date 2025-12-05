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
        // RESET SESSION: Hapus data draft formulir sebelumnya saat masuk halaman instruksi
        // Ini memastikan form bersih jika user memulai pengisian ulang
        session()->forget(['data_pribadi_form', 'data_pribadi_step2']);

        $user = Auth::user();
        // Cek apakah user sudah pernah mengisi data lengkap (Ambil yang terbaru)
        $dataSiswa = SiswaData::where('user_id', $user->id)->latest()->first();

        // Tetap return view instruksi
        return view('data_pribadi', compact('user', 'dataSiswa'));
    }

    /**
     * LANGKAH 1: Form Data Diri
     */
    public function form()
    {
        $user = Auth::user();

        // PERBAIKAN: Jangan ambil dari Database agar form kosong saat diulang.
        // Kita set null, lalu cek apakah ada session (jika user back dari step 2)
        $dataSiswa = null;

        if (session()->has('data_pribadi_form')) {
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

        // Cek akses: User wajib punya session step 1 untuk masuk ke sini jika ingin fresh start
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form');
        }

        // PERBAIKAN: Jangan ambil dari Database agar form kosong.
        $dataSiswa = null;

        if (session()->has('data_pribadi_step2')) {
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

        // Cek akses: Wajib ada session step 2
        if (!session()->has('data_pribadi_step2')) {
            return redirect()->route('data_pribadi.step2');
        }

        // PERBAIKAN: Jangan ambil dari Database, biarkan kosong kecuali ada session/inputan
        // Karena step 3 biasanya tidak ada session sebelumnya (langsung simpan), kita set null
        $dataSiswa = null;

        return view('data_pribadi_step3', compact('user', 'dataSiswa'));
    }

    /**
     * Simpan Langkah 3 & COMMIT KE DATABASE
     */
    public function storeStep3(Request $request)
    {
        // 1. Validasi Input (Semua nullable karena opsional)
        $request->validate([
            'nama_wali' => 'nullable|string',
            'alamat_wali' => 'nullable|string',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
        ]);

        // 2. Data Wali (Gunakan '-' jika kosong, atau biarkan null jika DB support null)
        // Kita gunakan '-' untuk konsistensi tampilan "Tersimpan tapi kosong"
        $dataWali = [
            'nama_wali'         => $request->filled('nama_wali') ? $request->nama_wali : null, // Atau '-'
            'alamat_wali'       => $request->filled('alamat_wali') ? $request->alamat_wali : null,
            'pendidikan_wali'   => $request->filled('pendidikan_wali') ? $request->pendidikan_wali : null,
            'pekerjaan_wali'    => $request->filled('pekerjaan_wali') ? $request->pekerjaan_wali : null,
            'penghasilan_wali'  => $request->filled('penghasilan_wali') ? $request->penghasilan_wali : null,
            'no_hp_wali'        => $request->filled('no_hp_wali') ? $request->no_hp_wali : null,
        ];

        // 3. Ambil Data Session (Step 1 & 2)
        $sessionStep1 = session()->get('data_pribadi_form', []);
        $sessionStep2 = session()->get('data_pribadi_step2', []);

        // 4. Cek Kelengkapan Data Session
        if (empty($sessionStep1)) {
             return redirect()->route('data_pribadi.form')
                 ->with('error', 'Sesi data pribadi habis. Mohon isi dari awal.');
        }

        // 5. Gabungkan Semua Data
        $finalData = array_merge($sessionStep1, $sessionStep2, $dataWali);
        $finalData['user_id'] = Auth::id();

        // 6. Handle JSON Array (Bantuan Pemerintah)
        if (!empty($finalData['bantuan_pemerintah'])) {
             if (is_array($finalData['bantuan_pemerintah'])) {
                 $finalData['bantuan_pemerintah'] = json_encode($finalData['bantuan_pemerintah']);
             } elseif (is_string($finalData['bantuan_pemerintah'])) {
                 // Pastikan format JSON valid
                 json_decode($finalData['bantuan_pemerintah']);
                 if (json_last_error() !== JSON_ERROR_NONE) {
                     $finalData['bantuan_pemerintah'] = json_encode([$finalData['bantuan_pemerintah']]);
                 }
             }
        } else {
             $finalData['bantuan_pemerintah'] = null;
        }

        try {
            // 7. Simpan ke Database
            SiswaData::create($finalData);

            // 8. Bersihkan Session
            $request->session()->forget(['data_pribadi_form', 'data_pribadi_step2']);

            // 9. Redirect ke Finish
            return redirect()->route('data_pribadi.finish')->with('success', 'Data pribadi Anda berhasil disimpan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Halaman Finish (Ringkasan Data)
     * Menampilkan view data_pribadi_finish
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil data TERBARU (latest)
        $dataSiswa = SiswaData::where('user_id', $user->id)->latest()->first();

        // 2. Jika data belum ada, lempar kembali ke form
        if (!$dataSiswa) {
            return redirect()->route('data_pribadi.form');
        }

        // 3. Format Ulang Data Bantuan (Decode JSON jika perlu)
        $bantuan = $dataSiswa->bantuan_pemerintah;
        // Cek apakah string JSON
        if (is_string($bantuan) && is_array(json_decode($bantuan, true)) && (json_last_error() == JSON_ERROR_NONE) ) {
             $bantuan = implode(', ', json_decode($bantuan, true));
        }
        // Jika sudah array (karena casting model), implode
        elseif (is_array($bantuan)) {
             $bantuan = implode(', ', $bantuan);
        }

        // Simpan data format siap tampil ke session flash (opsional, bisa langsung via object)
        // Kita gunakan object $dataSiswa langsung di view agar lebih mudah

        return view('data_pribadi_finish', compact('user', 'dataSiswa', 'bantuan'));
    }
}
