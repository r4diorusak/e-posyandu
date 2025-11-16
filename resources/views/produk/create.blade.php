@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk</h1>
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Barcode</label>
            <input type="text" name="barcode" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Modal</label>
                <input type="number" name="modal" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Persediaan</label>
                <input type="number" name="persediaan" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
