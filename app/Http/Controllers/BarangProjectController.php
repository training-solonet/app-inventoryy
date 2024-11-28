<?php

namespace App\Http\Controllers;

use App\Models\BarangProject;
use Illuminate\Http\Request;

class BarangProjectController extends Controller
{
    public function index()
    {
        $barangProjects = BarangProject::all(); // Get all items
        return view('databarangproject', compact('barangProjects'));
    }

    public function create()
    {
        return view('createbarangproject'); // Create view for adding barang
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barcode' => 'required|string|max:255|unique:barang_projects,kode_barcode',
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kondisi' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        // Simpan gambar ke folder 'public/images'
        $gambarPath = $request->file('gambar')->store('images', 'public');

        // Simpan data ke database
        BarangProject::create([
            'kode_barcode' => $request->kode_barcode,
            'nama_barang' => $request->nama_barang,
            'gambar' => $gambarPath,
            'kondisi' => $request->kondisi,
            'qty' => $request->qty,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('barang-project.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $barangProject = BarangProject::findOrFail($id);
        return view('editbarangproject', compact('barangProject'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kondisi' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        $barangProject = BarangProject::findOrFail($id);
        $barangProject->nama_barang = $request->nama_barang;
        $barangProject->kondisi = $request->kondisi;
        $barangProject->qty = $request->qty;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('images', 'public');
            $barangProject->gambar = $gambarPath;
        }

        $barangProject->save();

        return redirect()->route('barang-project.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barangProject = BarangProject::findOrFail($id);
        $barangProject->delete();

        return redirect()->route('barang-project.index')->with('success', 'Barang berhasil dihapus');
    }
}
