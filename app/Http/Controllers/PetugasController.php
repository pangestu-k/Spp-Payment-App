<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugasAll = Petugas::where('level', '=', 'petugas')->latest()->paginate(36);
        return view('spps.petugas.index', compact('petugasAll'));
    }

    public function create()
    {
        return view('spps.petugas.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'nama_petugas' => 'required',
            'email' => 'required|email|unique:table_petugas|unique:users',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['level'] = 'petugas';

        $petugasSimpan = Petugas::create($data);

        if ($petugasSimpan) {

            User::create([
                'name' => $data['nama_petugas'],
                'email' => $data['email'],
                'password' => $data['password'],
                'level' => $data['level'],
            ]);

            return redirect()->route('petugas.index')->with('success', 'data berhasil masuk');
        } else {
            return redirect()->back()->with('errpr', 'data gagal masuk');
        }
    }

    public function edit(Petugas $petuga)
    {
        return view('spps.petugas.edit', compact('petuga'));
    }

    public function update(Request $request, Petugas $petuga)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email',
            'nama_petugas' => 'required',
        ]);

        $data = $request->all();
        $data['level'] = 'petugas';
        $data['password'] !== null ?  $data['password'] = Hash::make($request->password) : $data['password'] = $petuga->password;

        $petugasUser = User::where('email', '=', $petuga->email)->first();
        $petugasUser->update([
            'name' => $data['nama_petugas'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        $petugasUpdate = $petuga->update($data);

        if ($petugasUpdate) {
            return redirect()->route('petugas.index')->with('success', 'data berhasil diedit');
        } else {
            return redirect()->back()->with('errpr', 'data gagal diedit');
        }
    }

    public function destroy(Petugas $petuga)
    {
        $petugasUser = User::where('email', '=', $petuga->email)->first();
        $petugasUser->delete();
        $petugasHapus = $petuga->delete();

        if ($petugasHapus) {
            return redirect()->route('petugas.index')->with('success', 'data berhasil dihapus');
        } else {
            return redirect()->back()->with('errpr', 'data gagal dihapus');
        }
    }
}
