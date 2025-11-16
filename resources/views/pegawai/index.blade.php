@extends('layouts.app')
@section('title','Daftar Pegawai')
@section('content')
<div class="box box-primary col-md-8">
  <div class="box-header">
    <a class="btn icon-btn btn-primary" href="{{ route('pegawai.create') }}">Tambah</a>
  </div>
  <div class="box-body">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <table id="dataTables" class="table table-bordered">
      <thead>
        <tr><th width="30">NO</th><th>Nama Pegawai</th><th>Level</th><th>Aksi</th></tr>
      </thead>
      <tbody>
      @php $no=1; @endphp
      @foreach($pegawai as $r)
        <tr>
          <td class="text-center">{{ $no++ }}</td>
          <td>{{ $r->username }}</td>
          <td class="text-center">{{ $r->level }}</td>
          <td class="text-center">
            <a class="btn icon-btn btn-info" href="{{ route('pegawai.edit', $r->id_pegawai) }}">Edit</a>
            <form action="{{ route('pegawai.destroy', $r->id_pegawai) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus data?')">
              @csrf @method('DELETE')
              <button class="btn icon-btn btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
