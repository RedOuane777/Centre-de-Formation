<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {

            $code = random_int(100000, 999999);

            $user->reset_code = Hash::make($code);
            $user->reset_code_expires_at = now()->addMinutes(10);
            $user->reset_attempts = 0;

            $plainToken = Str::random(64);
            $user->reset_token = Hash::make($plainToken);
            $user->reset_token_expires_at = now()->addMinutes(15);

            $user->save();

            Mail::raw("Votre code de réinitialisation est : $code", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Code de réinitialisation');
            });

            return redirect("/verify-code?email={$user->email}&token={$plainToken}");
        }

        return redirect()->route('password.verify.form')
            ->with('success', 'Si cet email existe, un code a été envoyé.');
    }

    public function showVerifyForm(Request $request)
    {
        if (!$request->email || !$request->token) {
            return redirect()->route('password.forgot');
        }

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !$user->reset_token ||
            !$user->reset_token_expires_at ||
            now()->greaterThan($user->reset_token_expires_at) ||
            !Hash::check($request->token, $user->reset_token)
        ) {
            return redirect()->route('password.forgot');
        }

        return view('auth.verify-code', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|digits:6',
            'token' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Code invalide']);
        }

        if (
            !$user->reset_token ||
            !$user->reset_token_expires_at ||
            now()->greaterThan($user->reset_token_expires_at) ||
            !Hash::check($request->token, $user->reset_token)
        ) {
            $this->clearReset($user);
            return back()->withErrors(['code' => 'Session expirée']);
        }

        if ($user->reset_attempts >= 3) {
            return back()->withErrors(['code' => 'Trop de tentatives']);
        }

        if (
            !$user->reset_code_expires_at ||
            now()->greaterThan($user->reset_code_expires_at)
        ) {
            $this->clearReset($user);
            return back()->withErrors(['code' => 'Code expiré']);
        }

        if (!Hash::check($request->code, $user->reset_code)) {
            $user->increment('reset_attempts');
            return back()->withErrors(['code' => 'Code invalide']);
        }

        $user->reset_attempts = 0;
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();

        return redirect()->route('password.reset.form', [
            'email' => $user->email,
            'token' => $request->token
        ]);
    }

    public function showResetForm(Request $request)
    {
        if (!$request->email || !$request->token) {
            return redirect()->route('password.forgot');
        }

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !$user->reset_token ||
            !$user->reset_token_expires_at ||
            now()->greaterThan($user->reset_token_expires_at) ||
            !Hash::check($request->token, $user->reset_token)
        ) {
            return response()->view('errors.forbidden', [], 403);
        }

        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !$user->reset_token ||
            !$user->reset_token_expires_at ||
            now()->greaterThan($user->reset_token_expires_at) ||
            !Hash::check($request->token, $user->reset_token)
        ) {
            return redirect()->route('password.forgot');
        }

        $user->password = Hash::make($request->password);

        $this->clearReset($user);

        return redirect()->route('login')
            ->with('success', 'Mot de passe modifié avec succès');
    }

    private function clearReset(User $user)
    {
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->reset_attempts = 0;
        $user->reset_token = null;
        $user->reset_token_expires_at = null;
        $user->save();
    }
}
