<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_pegawai','desc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:191',
            'password' => 'required|string|min:4',
            'level' => 'required|string|max:50',
        ]);

        // keep MD5 to remain compatible with legacy system; consider migrating to bcrypt
        $pass = md5($validated['password']);

        User::create([
            'username' => $validated['username'],
            'password' => $pass,
            'level' => $validated['level'],
        ]);

        return redirect()->route('users.index')->with('success','User dibuat');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:191',
            'password' => 'nullable|string|min:4',
            'level' => 'required|string|max:50',
        ]);

        $user = User::findOrFail($id);
        $user->username = $validated['username'];
        if (!empty($validated['password'])) {
            $user->password = md5($validated['password']);
        }
        $user->level = $validated['level'];
        $user->save();

        return redirect()->route('users.index')->with('success','User diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','User dihapus');
    }
}
