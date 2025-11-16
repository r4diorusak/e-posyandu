<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Use Eloquent to get user (so we can rehash easily)
        $user = User::where('username', $request->username)->first();

        if ($user) {
            $pw = $user->password ?? null;
            $matches = false;

            // 1) modern bcrypt / password_hash
            if ($pw !== null && Hash::check($request->password, $pw)) {
                $matches = true;
            }

            // 2) fallback: legacy MD5
            if (!$matches && $pw !== null && strlen($pw) === 32 && md5($request->password) === $pw) {
                // MD5 matched — rehash to bcrypt for future logins
                $user->password = Hash::make($request->password);
                $user->save();
                $matches = true;
            }

            // 3) fallback: plaintext (very unlikely but supported)
            if (!$matches && $pw === $request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
                $matches = true;
            }

            if ($matches) {
                // log user in via Auth facade to use Laravel session
                Auth::login($user);
                return redirect()->route('home');
            }
        }

        return redirect()->back()->with('error', 'Login gagal. Periksa username/password.');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.form');
    }
}
