@extends('layouts.app')
@section('title','Edit Pegawai')
@section('content')
<div class="box box-primary col-md-6">
  <div class="box-header"><h2>Edit Pegawai</h2></div>
  <div class="box-body">
    <form method="POST" action="{{ route('pegawai.update', $p->id_pegawai) }}">
      @csrf @method('PUT')
      <table class="table">
        <tr><td>Nama Pegawai</td><td><input type="text" name="nama" class="form-control" value="{{ $p->username }}">@error('nama')<div class="text-danger">{{ $message }}</div>@enderror</td></tr>
        <tr><td>Password</td><td><input type="text" name="pass" class="form-control"> <small>Kosongkan jika tidak diubah</small></td></tr>
        <tr><td>Level</td><td>
          <select name="level" class="form-control">
            <option value="kasir" {{ $p->level=='kasir'?'selected':'' }}>Kasir</option>
            <option value="android" {{ $p->level=='android'?'selected':'' }}>Android View</option>
          </select>
        </td></tr>
        <tr><td colspan=2><button class="btn btn-primary">Update</button>
            <a class="btn btn-default" href="{{ route('pegawai.index') }}">Batal</a></td></tr>
      </table>
    </form>
  </div>
</div>
@endsection
