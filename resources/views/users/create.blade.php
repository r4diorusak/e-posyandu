@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Level</label>
            <select name="level" class="form-control" required>
                <option value="Kasir">Kasir</option>
                <option value="Waiter">Waiter</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
