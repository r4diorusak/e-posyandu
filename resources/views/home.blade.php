@extends('layouts.app')

@section('title','Home')

@section('content')
    <h2>Selamat datang</h2>
    @if(session('user'))
        <p>Anda login sebagai: {{ session('user')->username ?? 'User' }}</p>
        <p><a href="{{ route('logout') }}">Logout</a></p>
    @else
        <p>Belum login.</p>
        <p><a href="{{ route('login.form') }}">Login</a></p>
    @endif
@endsection
