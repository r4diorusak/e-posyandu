@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produk</h1>
    <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr><th>No</th><th>Barcode</th><th>Nama</th><th>Persediaan</th><th>Harga</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($products as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->barcode }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->persediaan ?? 0 }}</td>
                <td>{{ $p->harga }}</td>
                <td>
                    <a href="{{ route('produk.edit',$p->barcode) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('produk.destroy',$p->barcode) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
