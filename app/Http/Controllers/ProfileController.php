<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Mot de passe actuel incorrect');
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('password_changed', 'Mot de passe modifié avec succès');
    }
}