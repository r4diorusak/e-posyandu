@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>
    <form action="{{ route('produk.update',$product->barcode) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Barcode</label>
            <input type="text" class="form-control" value="{{ $product->barcode }}" readonly>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $product->nama }}">
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $product->harga }}">
            </div>
            <div class="form-group col-md-4">
                <label>Modal</label>
                <input type="number" name="modal" class="form-control" value="{{ $product->modal }}">
            </div>
            <div class="form-group col-md-4">
                <label>Persediaan</label>
                <input type="number" name="persediaan" class="form-control" value="{{ $persediaan->persediaan ?? 0 }}">
            </div>
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
            @if(!empty($product->gambar))
                <img src="{{ asset($product->gambar) }}" style="max-height:120px;margin-top:8px">
            @endif
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
