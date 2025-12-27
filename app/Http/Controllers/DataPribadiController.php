<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\SiswaData;

class DataPribadiController extends Controller
{
    public function instruksi()
    {
		session()->forget(['data_pribadi_form','data_pribadi_step2','data_pribadi_step3']);

        $user = Auth::user();
        $dataSiswa = SiswaData::where('user_id',$user->id)->latest()->first();

        return view('data_pribadi',compact('user','dataSiswa'));
}

    public function form()
    {
        $user = Auth::user();
        $dataSiswa = null;

        // Hanya ambil data dari session jika sedang dalam proses isi form
        // Jangan ambil dari database untuk mencegah tampilnya data lama saat mulai ulang
        if (session()->has('data_pribadi_form')) {
            // Ubah array session jadi object agar bisa dibaca blade sebagai $dataSiswa->property
            $dataSiswa = (object) session('data_pribadi_form');
        }
        // DIHAPUS: Jangan ambil data dari database di halaman form
        // karena user ingin mulai fresh, bukan melanjutkan data lama

        return view('data_pribadi_form',compact('user','dataSiswa'));
    }

    /**
     * LANGKAH 1: Validasi Input HTML & Mapping ke Kolom DB
     */
    public function storeForm(Request $request)
    {
        // 1. VALIDASI (Wajib sama dengan name="..." di Blade HTML)
        $validated = $request->validate([
            'foto_profil'         => 'nullable|image|max:2048',
            'jenis_kelamin'       => 'required',
            'agama'               => 'required',
            'tempat_lahir'        => 'required',
            'tanggal_lahir'       => 'required|date',
            'status_anak'         => 'required',
            'anak_ke'             => 'required',
            'jumlah_saudara'      => 'required',
            'status_orang_tua'    => 'required',
            'uang_saku'           => 'required',
            'bantuan_pemerintah'  => 'nullable',
            'foto_kartu_bantuan'  => 'nullable|image|max:2048',
            'alamat'              => 'required',
            'kepemilikan_rumah'   => 'required',
            'no_hp'               => 'required',
            'hobi'                => 'required',
            'kelebihan'           => 'required',
            'kelemahan'           => 'required',
        ]);

        $user = Auth::user();

        // 2. Inject Data User
        $validated['nama_lengkap'] = $user->name;
        $validated['kelas'] = $user->kelas ?? '-';

        // --- A. HANDLE FOTO PROFIL ---
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time().'_profil_'.uniqid().'.'.$file->getClientOriginalExtension();

            $destinationPath = public_path('app/public/uploads/profil');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath,0755,true);
            }

            $file->move($destinationPath,$filename);
            $validated['foto_profil_path'] = 'uploads/profil/'.$filename;
        } elseif (session()->has('data_pribadi_form.foto_profil_path')) {
            $validated['foto_profil_path'] = session('data_pribadi_form.foto_profil_path');
        } elseif ($existing = SiswaData::where('user_id',$user->id)->first()) {
            $validated['foto_profil_path'] = $existing->foto_profil_path;
        }

        // --- B. HANDLE FOTO KARTU BANTUAN ---
        if ($request->hasFile('foto_kartu_bantuan')) {
            $file = $request->file('foto_kartu_bantuan');
            $filename = time().'_bantuan_'.uniqid().'.'.$file->getClientOriginalExtension();

            $destinationPath = public_path('app/public/uploads/bantuan');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath,0755,true,true);
            }

            $file->move($destinationPath,$filename);
            $validated['foto_kartu_bantuan_path'] = 'uploads/bantuan/'.$filename;
        } elseif (session()->has('data_pribadi_form.foto_kartu_bantuan_path')) {
            $validated['foto_kartu_bantuan_path'] = session('data_pribadi_form.foto_kartu_bantuan_path');
        } elseif ($existing = SiswaData::where('user_id',$user->id)->first()) {
            $validated['foto_kartu_bantuan_path'] = $existing->foto_kartu_bantuan_path;
        }

        // 3. BERSIHKAN KEY LAMA
        unset($validated['foto_profil'],$validated['foto_kartu_bantuan']);

        // 4. Simpan ke Session
        $request->session()->put('data_pribadi_form',$validated);

        return redirect()->route('data_pribadi.step2');
    }

    public function step2()
    {
        $user = Auth::user();
        if (!session()->has('data_pribadi_form')) {
            return redirect()->route('data_pribadi.form')->with('error','Silakan isi data pribadi terlebih dahulu.');
        }

        $dataSiswa = null;
        if (session()->has('data_pribadi_step2')) {
            $dataSiswa = (object) session('data_pribadi_step2');
        }

        return view('data_pribadi_step2',compact('user','dataSiswa'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'nama_ayah'        => 'required',
            'status_ayah'      => 'required',
            'pendidikan_ayah'  => 'required',
            'pekerjaan_ayah'   => 'nullable',
            'gaji_ayah'        => 'required',
            'alamat_ayah'      => 'nullable',
            'no_hp_ayah'       => 'nullable',
            'nama_ibu'         => 'required',
            'status_ibu'       => 'required',
            'pendidikan_ibu'   => 'required',
            'pekerjaan_ibu'    => 'nullable',
            'gaji_ibu'         => 'required',
            'alamat_ibu'       => 'nullable',
            'no_hp_ibu'        => 'nullable',
        ]);

        $request->session()->put('data_pribadi_step2',$validated);

        return redirect()->route('data_pribadi.step3');
    }

    public function step3()
    {
        $user = Auth::user();
        if (!session()->has('data_pribadi_form') || !session()->has('data_pribadi_step2')) {
            return redirect()->route('data_pribadi.form')->with('error','Sesi telah berakhir. Silakan mulai dari awal.');
        }

        $defaultValues = [
            'nama_wali'=>null,
            'alamat_wali'=>null,
            'pendidikan_wali'=>null,
            'pekerjaan_wali'=>null,
            'penghasilan_wali'=>null,
            'no_hp_wali'=>null,
        ];

        $savedState = session('data_pribadi_step3',[]);
        $dataSiswa = (object) array_merge($defaultValues,$savedState);

        return view('data_pribadi_step3',compact('user','dataSiswa'));
    }

    /**
     * LANGKAH TERAKHIR: Simpan ke Database
     */
    public function storeStep3(Request $request)
    {
        $validatedWali = $request->validate([
            'nama_wali'=>'nullable|string',
            'alamat_wali'=>'nullable|string',
            'pendidikan_wali'=>'nullable|string',
            'pekerjaan_wali'=>'nullable|string',
            'penghasilan_wali'=>'nullable|string',
            'no_hp_wali'=>'nullable|string',
        ]);

        $sessionStep1 = session()->get('data_pribadi_form',[]);
        $sessionStep2 = session()->get('data_pribadi_step2',[]);

        if (empty($sessionStep1)) {
            return redirect()->route('data_pribadi.form')->with('error','Sesi habis.');
        }

        $finalData = array_merge($sessionStep1,$sessionStep2,$validatedWali);
        $finalData['user_id'] = Auth::id();

        // UPDATE TABEL USERS (Avatar Navbar)
        if (!empty($finalData['foto_profil_path'])) {
            $userModel = \App\Models\User::find(Auth::id());
            if ($userModel) {
                if ($userModel->profile_photo_path && $userModel->profile_photo_path !== $finalData['foto_profil_path']) {
                    $oldFile = public_path('storage/app/public/'.$userModel->profile_photo_path);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }

                $userModel->profile_photo_path = $finalData['foto_profil_path'];
                $userModel->save();
            }
        }

        try {
            SiswaData::updateOrCreate(
                ['user_id'=>Auth::id()],
                $finalData
            );

            $request->session()->forget(['data_pribadi_form','data_pribadi_step2','data_pribadi_step3']);

            return redirect()->route('data_pribadi.finish')->with('success','Data berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error("Gagal Simpan: ".$e->getMessage());
            return back()->with('error','Gagal menyimpan: '.$e->getMessage());
        }
    }

    public function finish()
    {
        $user = Auth::user();
        $dataSiswa = SiswaData::where('user_id',$user->id)->latest()->first();
        if (!$dataSiswa) {
            return redirect()->route('data_pribadi.form');
        }

        $bantuan = $dataSiswa->bantuan_pemerintah;
        if (is_string($bantuan) && is_array(json_decode($bantuan,true)) && json_last_error() === JSON_ERROR_NONE) {
            $bantuan = implode(', ',json_decode($bantuan,true));
        }

        return view('data_pribadi_finish',compact('user','dataSiswa','bantuan'));
    }
}
