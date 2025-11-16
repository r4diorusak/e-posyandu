@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manajemen User</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr><th>No</th><th>Username</th><th>Level</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->level }}</td>
                <td>
                    <a href="{{ route('users.edit',$u->id_pegawai) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('users.destroy',$u->id_pegawai) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
