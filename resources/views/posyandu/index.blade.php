@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pasien</h1>
    <a href="{{ route('posyandu.create') }}" class="btn btn-primary">Tambah Pasien</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $p)
            <tr>
                <td>{{ $p->id_pasien }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->Alamat }}</td>
                <td>
                    <a href="{{ route('posyandu.show',$p->id_pasien) }}" class="btn btn-sm btn-info">Lihat</a>
                    <form action="{{ route('posyandu.destroyPatient',$p->id_pasien) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pasien?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
