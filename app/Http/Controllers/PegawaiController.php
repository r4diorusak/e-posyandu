<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = DB::table('users')->orderBy('id_pegawai', 'desc')->get();
        return view('pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pass' => 'required',
            'level' => 'required',
        ]);

        $pass = md5($request->pass);

        DB::table('users')->insert([
            'username' => $request->nama,
            'password' => $pass,
            'level' => $request->level,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai ditambahkan.');
    }

    public function edit($id)
    {
        $p = DB::table('users')->where('id_pegawai', $id)->first();
        if (!$p) return redirect()->route('pegawai.index')->with('error','Data tidak ditemukan');
        return view('pegawai.edit', ['p' => $p]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'level' => 'required',
        ]);

        $data = [
            'username' => $request->nama,
            'level' => $request->level,
        ];
        if (!empty($request->pass)) {
            $data['password'] = md5($request->pass);
        }

        DB::table('users')->where('id_pegawai', $id)->update($data);
        return redirect()->route('pegawai.index')->with('success','Pegawai diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id_pegawai', $id)->delete();
        return redirect()->route('pegawai.index')->with('success','Pegawai dihapus.');
    }
}
