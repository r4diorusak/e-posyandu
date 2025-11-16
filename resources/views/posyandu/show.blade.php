@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pasien: {{ $patient->nama }}</h1>
    <p>Alamat: {{ $patient->Alamat }}</p>

    <h3>Tambah Rekam Medis</h3>
    <form action="{{ route('posyandu.records.store',$patient->id_pasien) }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="BB" placeholder="BB" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="text" name="TB" placeholder="TB" class="form-control">
            </div>
            <div class="col-md-1">
                <input type="number" name="TDS" placeholder="TDS" class="form-control">
            </div>
            <div class="col-md-1">
                <input type="number" name="TDD" placeholder="TDD" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="text" name="LP" placeholder="LP" class="form-control">
            </div>
            <div class="col-md-1">
                <button class="btn btn-success">Tambah</button>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col-md-2"><input type="text" name="GDA" placeholder="GDA" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="KOL" placeholder="KOL" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="AU" placeholder="AU" class="form-control"></div>
            <div class="col-md-6"><input type="text" name="OBAT" placeholder="OBAT" class="form-control"></div>
        </div>
        <div class="form-row mt-2">
            <div class="col-md-4"><input type="text" name="Pemeriksa" placeholder="Pemeriksa" class="form-control"></div>
            <div class="col-md-8"><input type="text" name="Catatan" placeholder="Catatan" class="form-control"></div>
        </div>
    </form>

    <h3 class="mt-4">Rekam Medis</h3>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>BB</th>
                <th>TB</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $r)
            <tr>
                <td>{{ $r->no }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>{{ $r->BB }}</td>
                <td>{{ $r->TB }}</td>
                <td>
                    <form action="{{ route('posyandu.records.destroy',[$patient->id_pasien,$r->no]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
