<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudiHabitController extends Controller
{
    /**
     * Menampilkan halaman instruksi (Landing Page Studi Habit).
     */
    public function index()
    {
        $user = Auth::user();
        return view('studi_habit', compact('user'));
    }

    /**
     * Menampilkan halaman form soal.
     */
    public function form()
    {
        $user = Auth::user();
        return view('studi_habit_form', compact('user'));
    }

    /**
     * Menyimpan jawaban dari form.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        // Logika penyimpanan data (sesuaikan dengan Model Anda nanti)
        /*
        StudiHabitResult::create([
            'user_id' => Auth::id(),
            'answers' => $data,
            'score'   => ...,
        ]);
        */

        // Redirect ke halaman step 2 (gaya belajar)
        return redirect()->route('studi_habit.step2');
    }

    /**
     * Menampilkan halaman step 2 (Gaya Belajar).
     */
    public function step2()
    {
        $user = Auth::user();
        return view('studi_habit_step2', compact('user'));
    }

    /**
     * Menyimpan jawaban step 2 (Gaya Belajar).
     */
    public function storeStep2(Request $request)
    {
        $data = $request->except('_token');

        // Logika penyimpanan data step 2 (sesuaikan dengan Model Anda nanti)
        /*
        StudiHabitResult::update([
            'gaya_belajar' => $data,
        ]);
        */

        // Redirect ke halaman selesai
        return redirect()->route('studi_habit.finish');
    }

    /**
     * Menampilkan halaman selesai.
     */
    public function finish()
    {
        $user = Auth::user();
        return view('studi_habit_finish', compact('user'));
    }
}
