<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosyanduController extends Controller
{
    public function index(Request $request)
    {
        $patients = DB::table('pasien')->orderBy('id_pasien', 'desc')->get();
        return view('posyandu.index', compact('patients'));
    }

    public function create()
    {
        return view('posyandu.create');
    }

    public function storePatient(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:191',
            'alamat' => 'nullable|string|max:255',
            'usia' => 'nullable|integer|min:0|max:200',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'Rsekarang' => 'nullable|string|max:255',
            'Rkeluarga' => 'nullable|string|max:255',
            'merokok' => 'nullable|in:Ya,Tidak',
            'R_olahraga' => 'nullable|in:Ya,Tidak',
            'K_garam' => 'nullable|in:Ya,Tidak',
            'K_sayur' => 'nullable|in:Ya,Tidak',
            'K_lemak' => 'nullable|in:Ya,Tidak',
        ]);

        $id = DB::table('pasien')->insertGetId([
            'nama' => $validated['nama'],
            'Alamat' => $validated['alamat'] ?? null,
            'Usia' => $validated['usia'] ?? null,
            'Jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'Pendidikan_terakhir' => $validated['pendidikan'] ?? null,
            'Pekerjaan' => $validated['pekerjaan'] ?? null,
            'Status_perkawinan' => $validated['status'] ?? null,
            'R_penyakit_sekarang' => $validated['Rsekarang'] ?? null,
            'R_penyakit_keluarga' => $validated['Rkeluarga'] ?? null,
            'Merokok' => $validated['merokok'] ?? null,
            'Rutin_olahraga' => $validated['R_olahraga'] ?? null,
            'K_garam_berlebih' => $validated['K_garam'] ?? null,
            'K_sayur_dan_buah' => $validated['K_sayur'] ?? null,
            'K_makanan_berlemak' => $validated['K_lemak'] ?? null,
        ]);

        return redirect()->route('posyandu.show', $id)->with('success','Pasien ditambahkan');
    }

    public function show($id)
    {
        $patient = DB::table('pasien')->where('id_pasien',$id)->first();
        if (!$patient) return redirect()->route('posyandu.index')->with('error','Pasien tidak ditemukan');
        $records = DB::table('rekam_medis')->where('id_pasien',$id)->orderBy('tanggal','desc')->get();
        return view('posyandu.show', compact('patient','records'));
    }

    public function storeRecord(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'BB' => 'nullable|string|max:50',
            'TB' => 'nullable|string|max:50',
            'TDS' => 'nullable|integer',
            'TDD' => 'nullable|integer',
            'LP' => 'nullable|string|max:50',
            'GDA' => 'nullable|string|max:50',
            'KOL' => 'nullable|string|max:50',
            'AU' => 'nullable|string|max:50',
            'OBAT' => 'nullable|string|max:255',
            'Pemeriksa' => 'nullable|string|max:100',
            'Catatan' => 'nullable|string|max:1000',
        ]);

        // prevent duplicate tanggal for same pasien
        $exists = DB::table('rekam_medis')->where('id_pasien',$id)->where('tanggal',$validated['tanggal'])->exists();
        if ($exists) return redirect()->back()->with('error','Tanggal rekam medis sudah ada untuk pasien ini');

        DB::table('rekam_medis')->insert([
            'id_pasien' => $id,
            'tanggal' => $validated['tanggal'],
            'BB' => $validated['BB'] ?? null,
            'TB' => $validated['TB'] ?? null,
            'TD_sistolik' => $validated['TDS'] ?? null,
            'TD_diastole' => $validated['TDD'] ?? null,
            'LP' => $validated['LP'] ?? null,
            'GDA' => $validated['GDA'] ?? null,
            'KOL' => $validated['KOL'] ?? null,
            'AU' => $validated['AU'] ?? null,
            'OBAT' => $validated['OBAT'] ?? null,
            'Pemeriksa' => $validated['Pemeriksa'] ?? null,
            'Catatan' => $validated['Catatan'] ?? null,
        ]);

        return redirect()->route('posyandu.show', $id)->with('success','Rekam medis ditambahkan');
    }

    public function destroyPatient($id)
    {
        DB::table('rekam_medis')->where('id_pasien',$id)->delete();
        DB::table('pasien')->where('id_pasien',$id)->delete();
        return redirect()->route('posyandu.index')->with('success','Pasien dan rekaman dihapus');
    }

    public function destroyRecord($id_pasien, $no)
    {
        DB::table('rekam_medis')->where('no',$no)->delete();
        return redirect()->route('posyandu.show', $id_pasien)->with('success','Rekam medis dihapus');
    }
}
