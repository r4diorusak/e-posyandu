@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pasien</h1>
    <form action="{{ route('posyandu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Usia</label>
                <input type="number" name="usia" class="form-control" min="0">
            </div>
            <div class="form-group col-md-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Pendidikan Terakhir</label>
                <input type="text" name="pendidikan" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Status Perkawinan</label>
                <input type="text" name="status" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Riwayat Penyakit Sekarang</label>
                <input type="text" name="Rsekarang" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Riwayat Penyakit Keluarga</label>
                <input type="text" name="Rkeluarga" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Merokok</label>
                <select name="merokok" class="form-control">
                    <option value="">-</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Rutin Olahraga</label>
                <select name="R_olahraga" class="form-control">
                    <option value="">-</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>K_garam_berlebih</label>
                <select name="K_garam" class="form-control">
                    <option value="">-</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>K_sayur_dan_buah</label>
                <select name="K_sayur" class="form-control">
                    <option value="">-</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>K_makanan_berlemak</label>
            <select name="K_lemak" class="form-control">
                <option value="">-</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
            </select>
        </div>
        <button class="btn btn-primary mt-2">Simpan</button>
    </form>
</div>
@endsection
