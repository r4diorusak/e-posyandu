@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update',$user->id_pegawai) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </div>
        <div class="form-group">
            <label>Password (biarkan kosong jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Level</label>
            <select name="level" class="form-control" required>
                <option value="Kasir" {{ $user->level=='Kasir'? 'selected':'' }}>Kasir</option>
                <option value="Waiter" {{ $user->level=='Waiter'? 'selected':'' }}>Waiter</option>
                <option value="Admin" {{ $user->level=='Admin'? 'selected':'' }}>Admin</option>
            </select>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
