<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimpor

class PetugasController extends Controller
{
    // Menampilkan semua petugas
    public function index()
    {
        $petugas = User::where('level', '!=', 'user')->get(); // Menampilkan hanya petugas
        return view('tb_petugas', compact('petugas'));
    }

    // Menyimpan petugas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:operator,admin',
        ]);

        // Buat petugas baru
        User::create([
            'name' => $request->nama_petugas,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    // Menampilkan formulir edit
    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('petugas', compact('petugas'));
    }

    // Memperbarui petugas
    public function update(Request $request, $id)
    {
        $petugas = User::findOrFail($id);

        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
            'level' => 'required|string|in:operator,admin,supervisor',
        ]);

        $petugas->name = $request->nama_petugas;
        $petugas->username = $request->username;
        if ($request->filled('password')) {
            $petugas->password = bcrypt($request->password);
        }
        $petugas->level = $request->level;

        $petugas->save();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diperbarui!');
    }

    // Menghapus petugas
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }
}
