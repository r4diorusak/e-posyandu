<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('password.change');
    }

    public function change(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:4|confirmed',
        ]);

        $user = auth()->user();
        if (!$user) return redirect()->route('login.form');

        $pw = $user->password ?? null;

        $matches = false;
        // bcrypt check
        if ($pw !== null && Hash::check($request->current_password, $pw)) {
            $matches = true;
        }
        // fallback md5
        if (!$matches && $pw !== null && strlen($pw) === 32 && md5($request->current_password) === $pw) {
            $matches = true;
        }
        // fallback plaintext
        if (!$matches && $pw === $request->current_password) {
            $matches = true;
        }

        if (!$matches) {
            return back()->with('error','Password lama salah');
        }

        // update users table with bcrypt
        $user->password = Hash::make($request->new_password);
        $user->save();

        // If legacy admin table exists and user is admin, update admin table with MD5 for backward compatibility
        try {
            if (isset($user->level) && strtolower($user->level) === 'admin') {
                $adminExists = DB::table('admin')->where('username', $user->username)->exists();
                if ($adminExists) {
                    DB::table('admin')->where('username', $user->username)->update(['password' => md5($request->new_password)]);
                }
            }
        } catch (\Exception $e) {
            // ignore if admin table not present
        }

        return redirect()->route('home')->with('success','Password berhasil diubah');
    }
}
