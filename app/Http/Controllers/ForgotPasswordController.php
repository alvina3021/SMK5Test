<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Form Input Email
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    // 2. Kirim Link Reset ke Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kirim link menggunakan fitur bawaan Laravel
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // 3. Tampilkan Form Reset Password (setelah klik link di email)
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset_password')->with(
            ['token' => $request->input('token'), 'email' => $request->input('email')]
        );
    }

    // 4. Proses Update Password Baru
   public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

$status = Password::reset(
    $request->only('email', 'password', 'password_confirmation', 'token'),
    function ($user, $password) {
        $user->forceFill([
            'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    }
);

    if ($status === Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
    }

    return back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => __($status)]);
}
}