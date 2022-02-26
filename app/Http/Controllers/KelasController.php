<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelasAll = Kelas::latest()->paginate(36);
        return view('spps.kelas.index', compact('kelasAll'));
    }

    public function create()
    {
        return view('spps.kelas.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        $data = $request->all();
        $kelasSimpan = Kelas::create($data);

        if ($kelasSimpan) {
            return redirect()->route('kelas.index')->with('success', 'data berhasil masuk');
        } else {
            return redirect()->back()->with('errpr', 'data gagal masuk');
        }
    }

    public function edit(Kelas $kela)
    {
        return view('spps.kelas.edit', compact('kela'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $this->validate($request, [
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        $data = $request->all();

        $kelasUpdate = $kela->update($data);

        if ($kelasUpdate) {
            return redirect()->route('kelas.index')->with('success', 'data berhasil diedit');
        } else {
            return redirect()->back()->with('errpr', 'data gagal diedit');
        }
    }

    public function destroy(Kelas $kela)
    {
        $kelasHapus = $kela->delete();

        if ($kelasHapus) {
            return redirect()->route('kelas.index')->with('success', 'data berhasil dihapus');
        } else {
            return redirect()->back()->with('errpr', 'data gagal dihapus');
        }
    }
}
