<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SosialEmosionalResult; // Pastikan Model di-import

class SosialEmosionalController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Apakah user ini sudah mengerjakan?
        $sudahMengerjakan = SosialEmosionalResult::where('user_id', $user->id)->exists();

        // 2. LOGIKA PENGALIHAN
        if ($sudahMengerjakan) {
            // JIKA SUDAH: Langsung tampilkan view Selesai
            return view('sosial_emosional_finish', compact('user'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi
        return view('sosial_emosional', compact('user'));
    }

    /**
     * STEP 1: FORM DATA SOSIAL & EMOSIONAL
     */
    public function form()
    {
        $user = Auth::user();

        // PROTEKSI: Jika sudah selesai, tendang ke index
        if (SosialEmosionalResult::where('user_id', $user->id)->exists()) {
             return redirect()->route('sosial_emosional.index');
        }

        return view('sosial_emosional_form', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 1 (Ke Session)
     */
    public function store(Request $request)
    {
        // 1. Ambil Data Step 1
        $dataStep1 = $request->except('_token');

        // 2. Simpan ke Session (Sementara)
        $request->session()->put('sosial_emosional_step1', $dataStep1);

        // 3. Redirect ke Halaman Step 2
        // Pastikan nama route ini sesuai dengan yang ada di web.php ('sosial_emosional_step2')
        return redirect()->route('sosial_emosional_step2');
    }

    /**
     * STEP 2: KESEHATAN MENTAL
     */
    public function step2()
    {
        $user = Auth::user();

        // PROTEKSI 1: Jika sudah selesai di DB
        if (SosialEmosionalResult::where('user_id', $user->id)->exists()) {
             return redirect()->route('sosial_emosional.index');
        }

        // PROTEKSI 2: Jika user lompat langsung ke step 2 tanpa isi step 1
        if (!session()->has('sosial_emosional_step1')) {
            return redirect()->route('sosial_emosional.form');
        }

        return view('sosial_emosional_step2', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 2 (FINAL - Ke Database)
     */
    public function storeStep2(Request $request)
    {
        // 1. Ambil Data Step 2
        $dataStep2 = $request->except('_token');

        // 2. Ambil Data Step 1 dari Session
        $dataStep1 = session()->get('sosial_emosional_step1');

        // 3. Gabungkan Semua Jawaban
        $allAnswers = array_merge($dataStep1, $dataStep2);

        // 4. Simpan ke Database
        SosialEmosionalResult::create([
            'user_id' => Auth::id(),
            'answers' => $allAnswers, // Disimpan sebagai JSON
        ]);

        // 5. Bersihkan Session
        $request->session()->forget('sosial_emosional_step1');

        // 6. REDIRECT KE INDEX
        // Method index() akan mendeteksi data sudah ada dan menampilkan halaman finish.
        return redirect()->route('sosial_emosional.index');
    }

    /**
     * HALAMAN SELESAI (Opsional)
     */
    public function finish()
    {
        $user = Auth::user();
        return view('sosial_emosional_finish', compact('user'));
    }
}
