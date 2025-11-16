<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Generate PDF for a patient's rekam medis using the existing ezpdf class
    public function rekamPdf($id_pasien)
    {
        $classPath = base_path('modul/mod_laporan/class.ezpdf.php');
        $rupiahPath = base_path('modul/mod_laporan/rupiah.php');
        if (!file_exists($classPath)) abort(500, 'PDF library missing');

        include_once $classPath;
        include_once $rupiahPath;

        $pdf = new Cezpdf();
        $pdf->ezSetCmMargins(3,3,3,3);
        $pdf->selectFont(base_path('modul/mod_laporan/fonts/Courier.afm'));

        $all = $pdf->openObject();
        $pdf->setStrokeColor(0,0,0,1);
        $pdf->addText(325, 560, 16,'<b>Laporan Rekam Medis</b>');
        $pdf->line(10, 533, 830, 533);
        $pdf->line(10, 530, 830, 530);
        $pdf->line(10, 50, 830, 50);
        $pdf->addText(30,34,8,'Dicetak tgl:' . date( 'd-m-Y, H:i:s'));
        $pdf->closeObject();
        $pdf->addObject($all, 'all');

        $rows = DB::table('rekam_medis')->where('id_pasien',$id_pasien)->orderBy('tanggal','desc')->get();
        if ($rows->isEmpty()) return back()->with('error','Tidak ada rekam medis untuk pasien ini');

        $data = [];
        $i = 1;
        foreach ($rows as $r) {
            $data[$i] = [
                '<b>No</b>' => $i,
                '<b>ID Pasien</b>' => $r->id_pasien,
                '<b>Tanggal</b>' => $r->tanggal,
                '<b>BB</b>' => $r->BB,
                '<b>TB</b>' => $r->TB,
                '<b>TDD</b>' => $r->TD_sistolik,
                '<b>TDS</b>' => $r->TD_diastole,
                '<b>LP</b>' => $r->LP,
                '<b>GDA</b>' => $r->GDA,
                '<b>KOL</b>' => $r->KOL,
                '<b>AU</b>' => $r->AU,
                '<b>Obat</b>' => $r->OBAT,
                '<b>Pemeriksa</b>' => $r->Pemeriksa,
                '<b>Catatan</b>' => $r->Catatan,
            ];
            $i++;
        }

        $pdf->ezTable($data, '', '', '');

        $pasien = DB::table('pasien')->where('id_pasien',$id_pasien)->first();
        if ($pasien) {
            $pdf->ezText("\n\n<b>Pasien</b>");
            $pdf->ezText("Nama :{$pasien->nama}");
            $pdf->ezText("Alamat :{$pasien->Alamat}");
            $pdf->ezText("Usia :{$pasien->Usia}");
            $pdf->ezText("Jenis Kelamin :{$pasien->Jenis_kelamin}");
            $pdf->ezText("Pendidikan Terakhir :{$pasien->Pendidikan_terakhir}");
            $pdf->ezText("Pekerjaan :{$pasien->Pekerjaan}");
            $pdf->ezText("Status :{$pasien->Status_perkawinan}");
            $pdf->ezText("Riwayat Penyakit Sekarang :{$pasien->R_penyakit_sekarang}");
            $pdf->ezText("Riwayat Penyakit Keluarga :{$pasien->R_penyakit_keluarga}");
            $pdf->ezText("Merokok :{$pasien->Merokok}");
            $pdf->ezText("Rutin Olahraga :{$pasien->Rutin_olahraga}");
            $pdf->ezText("Komsumsi Garam Berlebih :{$pasien->K_garam_berlebih}");
            $pdf->ezText("Komsumsi Sayur dan Buah :{$pasien->K_sayur_dan_buah}");
            $pdf->ezText("Komsumsi Makanan Berlemak :{$pasien->K_makanan_berlemak}");
        }

        $pdf->ezStartPageNumbers(320, 15, 8);
        return $pdf->ezStream();
    }
}
