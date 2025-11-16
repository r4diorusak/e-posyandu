@extends('layouts.app')
@section('title','Tambah Pegawai')
@section('content')
<div class="box box-primary col-md-6">
  <div class="box-header"><h2>Tambah Pegawai</h2></div>
  <div class="box-body">
    <form method="POST" action="{{ route('pegawai.store') }}">
      @csrf
      <table class="table">
        <tr><td>Nama Pegawai</td><td><input type="text" name="nama" class="form-control" value="{{ old('nama') }}">@error('nama')<div class="text-danger">{{ $message }}</div>@enderror</td></tr>
        <tr><td>Password</td><td><input type="text" name="pass" class="form-control">@error('pass')<div class="text-danger">{{ $message }}</div>@enderror</td></tr>
        <tr><td>Level</td><td>
          <select name="level" class="form-control">
            <option value="kasir">Kasir</option>
            <option value="android">Android View</option>
          </select>
        </td></tr>
        <tr><td colspan=2><button class="btn btn-primary">Simpan</button>
            <a class="btn btn-default" href="{{ route('pegawai.index') }}">Batal</a></td></tr>
      </table>
    </form>
  </div>
</div>
@endsection
