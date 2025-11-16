<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $products = DB::table('produk as a')
            ->join('persediaan as b','a.barcode','b.barcode')
            ->leftJoin('lokasi as c','a.lokasi','c.id_lokasi')
            ->select('a.*','b.persediaan','c.nama_lokasi')
            ->orderBy('a.id_produk','desc')
            ->get();
        return view('produk.index', compact('products'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|string|max:100|unique:produk,barcode',
            'nama' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'modal' => 'nullable|numeric',
            'persediaan' => 'nullable|integer',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('photos/produk','public');
            $gambar = 'storage/'.$path;
        }

        Produk::create([
            'barcode' => $validated['barcode'],
            'nama' => $validated['nama'] ?? null,
            'gambar' => $gambar,
            'harga' => $validated['harga'] ?? 0,
            'modal' => $validated['modal'] ?? 0,
        ]);

        DB::table('persediaan')->insert([
            'barcode' => $validated['barcode'],
            'persediaan' => $validated['persediaan'] ?? 0,
            'terakhir_rubah' => now(),
        ]);

        return redirect()->route('produk.index')->with('success','Produk ditambahkan');
    }

    public function edit($id)
    {
        // $id is barcode or id_produk — legacy used barcode for some flows; find by barcode or id
        $product = DB::table('produk')->where('barcode',$id)->orWhere('id_produk',$id)->first();
        if (!$product) abort(404);
        $persediaan = DB::table('persediaan')->where('barcode',$product->barcode)->first();
        return view('produk.edit', compact('product','persediaan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'modal' => 'nullable|numeric',
            'persediaan' => 'nullable|integer',
        ]);

        $product = DB::table('produk')->where('barcode',$id)->orWhere('id_produk',$id)->first();
        if (!$product) abort(404);

        $data = [
            'nama' => $validated['nama'] ?? $product->nama,
            'harga' => $validated['harga'] ?? $product->harga,
            'modal' => $validated['modal'] ?? $product->modal,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('photos/produk','public');
            $data['gambar'] = 'storage/'.$path;
        }

        DB::table('produk')->where('barcode',$product->barcode)->update($data);
        DB::table('persediaan')->where('barcode',$product->barcode)->update([
            'persediaan' => $validated['persediaan'] ?? 0,
            'terakhir_rubah' => now(),
        ]);

        return redirect()->route('produk.index')->with('success','Produk diperbarui');
    }

    public function destroy($id)
    {
        $product = DB::table('produk')->where('barcode',$id)->orWhere('id_produk',$id)->first();
        if (!$product) abort(404);
        DB::table('persediaan')->where('barcode',$product->barcode)->delete();
        DB::table('produk')->where('barcode',$product->barcode)->delete();
        return redirect()->route('produk.index')->with('success','Produk dihapus');
    }
}
