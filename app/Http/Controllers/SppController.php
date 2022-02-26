<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $sppAll = Spp::latest()->paginate(36);
        return view('spps.spp.index', compact('sppAll')); 
    }

    public function create()
    {
        return view('spps.spp.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        $data = $request->all();
        $tahunSelenjutnya = $request->tahun + 2;
        $data['tahun'] = $request->tahun . $tahunSelenjutnya;

        if ($request->tahun < 1990) {
            return back()->with('error', 'Tahun sudah tidak berlaku');
        }

        if ($request->nominal < 10000) {
            return back()->with('tnominal', 'Nominal tidak wajar');
        }

        $sppSimpan = Spp::create($data);

        if ($sppSimpan) {
            return redirect()->route('spp.index')->with('success', 'data berhasil masuk');
        } else {
            return redirect()->back()->with('errpr', 'data gagal masuk');
        }
    }

    public function edit(Spp $spp)
    {
        return view('spps.spp.edit', compact('spp'));
    }

    public function update(Request $request, Spp $spp)
    {
        $this->validate($request, [
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        $data = $request->all();
        $tahunSelenjutnya = $request->tahun + 2;
        $data['tahun'] = $request->tahun . $tahunSelenjutnya;

        if ($request->tahun < 1990) {
            return back()->with('error', 'Tahun sudah tidak berlaku');
        }

        if ($request->nominal < 10000) {
            return back()->with('tnominal', 'Nominal tidak wajar');
        }

        $sppUpdate = $spp->update($data);

        if ($sppUpdate) {
            return redirect()->route('spp.index')->with('success', 'data berhasil diedit');
        } else {
            return redirect()->back()->with('errpr', 'data gagal diedit');
        }
    }

    public function destroy(Spp $spp)
    {
        $sppHapus = $spp->delete();

        if ($sppHapus) {
            return redirect()->route('spp.index')->with('success', 'data berhasil dihapus');
        } else {
            return redirect()->back()->with('errpr', 'data gagal dihapus');
        }
    }
}
