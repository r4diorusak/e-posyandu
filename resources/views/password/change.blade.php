@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ganti Password</h1>
    <form action="{{ route('password.change') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ulangi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-primary">Ganti Password</button>
    </form>
</div>
@endsection
