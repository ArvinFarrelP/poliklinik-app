<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')
            ->with('poli')
            ->get();

        return view('dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::all();

        return view('dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp',
            'no_hp'    => 'required|string|max:15',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'id_poli'  => $request->id_poli,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'dokter',
        ]);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil ditambahkan')
            ->with('type', 'success');
    }

    public function edit(User $dokter)
    {
        $polis = Poli::all();

        return view('dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp,' . $dokter->id,
            'no_hp'    => 'required|string|max:15',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|unique:users,email,' . $dokter->id,
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'nama'    => $request->nama,
            'alamat'  => $request->alamat,
            'no_ktp'  => $request->no_ktp,
            'no_hp'   => $request->no_hp,
            'id_poli' => $request->id_poli,
            'email'   => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $dokter->update($updateData);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil diubah')
            ->with('type', 'success');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil dihapus')
            ->with('type', 'success');
    }
}
