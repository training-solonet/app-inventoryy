<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
{
    $petugas = User::whereIn('role', ['operator', 'admin'])->get();
    return view('tb_petugas', compact('petugas'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:operator,admin',
        ]);

        User::create($request->only(['name', 'email', 'role', 'password']));

        return redirect()->back()->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:8',
            'role' => 'required|in:operator,admin',
        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Akan otomatis di-hash melalui mutator
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Petugas berhasil dihapus.');
    }
}
