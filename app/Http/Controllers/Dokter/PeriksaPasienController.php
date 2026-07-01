<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksa'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();

        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obats = json_decode($request->obat_json, true);

        if (!$obats || count($obats) === 0) {
            return back()->with('error', 'Pilih minimal satu obat.');
        }

        foreach ($obats as $item) {
            $obat = Obat::findOrFail($item['id']);
            $jumlah = (int) $item['jumlah'];

            if ($jumlah < 1) {
                return back()->with('error', 'Jumlah obat tidak valid.');
            }

            if ($obat->stok < $jumlah) {
                return back()->with('error', 'Stok obat ' . $obat->nama_obat . ' tidak mencukupi. Stok tersedia: ' . $obat->stok);
            }
        }

        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa' => now(),
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa + 150000,
        ]);

        foreach ($obats as $item) {
            $obat = Obat::findOrFail($item['id']);
            $jumlah = (int) $item['jumlah'];

            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obat->id,
                'jumlah' => $jumlah,
            ]);

            $obat->decrement('stok', $jumlah);
        }

        return redirect()->route('periksa-pasien.index')
            ->with('success', 'Data periksa berhasil disimpan dan stok obat otomatis berkurang.');
    }
}
