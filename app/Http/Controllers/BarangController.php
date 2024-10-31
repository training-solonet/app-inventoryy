<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('created_at', 'desc')->get(); // Mengurutkan barang terbaru di paling atas
        return view('tb_barang', [
            "active" => 'barang',
            "barangs" => $barangs
        ]);
    }

     // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kondisi' => 'required|string|max:255',
            'jenis' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->kondisi = $request->kondisi;
        $barang->jenis = $request->jenis;

        // Menghandle upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $barang->gambar = $filename;
        }

        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kondisi' => 'required|string|max:255',
            'jenis' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->kondisi = $request->kondisi;
        $barang->jenis = $request->jenis;

        // Mengganti gambar jika ada unggahan baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar && file_exists(public_path('images/' . $barang->gambar))) {
                unlink(public_path('images/' . $barang->gambar));
            }

            // Unggah gambar baru
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $barang->gambar = $filename;
        }

        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus gambar dari direktori jika ada
        if ($barang->gambar && file_exists(public_path('images/' . $barang->gambar))) {
            unlink(public_path('images/' . $barang->gambar));
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }



}
