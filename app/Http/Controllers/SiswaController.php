<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswaAll = Siswa::latest()->paginate(36);
        $kelasAll = Kelas::all();
        $sppAll = Spp::all();

        return view('spps.siswa.index', compact('siswaAll', 'kelasAll', 'sppAll'));
    }

    public function create()
    {
        $kelasAll = Kelas::all();
        $sppAll = Spp::all();
        return view('spps.siswa.create', compact('kelasAll', 'sppAll'));
    }

    public function store(Request $request)
    {

        $message = [
            'nisn.min' => "Nisn must 8 Character",
            'nis.min' => "Nis must 8 Character"
        ];

        $this->validate($request, [
            'nisn' => 'required|numeric|unique:table_siswa|min:100000000',
            'nis' => 'required|numeric|unique:table_siswa|min:10000000',
            'nama' => 'required',
            'id_kelas' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required|numeric',
            'id_spp' => 'required',
        ], $message);

        $data = $request->all();
        $data['email'] = $request->nis . "@gmail.com";
        $data['level'] = 'siswa';
        $siswaSimpan = Siswa::create($data);

        if ($siswaSimpan) {
            // buat user siswa di tb_user
            User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($request->nis),
                'level' => 'siswa',
            ]);

            return redirect()->route('siswa.index')->with('success', 'data berhasil masuk');
        } else {
            return redirect()->back()->with('error', 'data gagal masuk');
        }
    }

    public function edit(Siswa $siswa)
    {
        $kelasAll = Kelas::all();
        $sppAll = Spp::all();
        return view('spps.siswa.edit', compact('siswa', 'kelasAll', 'sppAll'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $this->validate($request, [
            'nisn' => 'required|numeric',
            'nis' => 'required|numeric',
            'nama' => 'required',
            'id_kelas' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required|numeric',
            'id_spp' => 'required',
        ]);

        $data = $request->all();
        $data['email'] = $request->nis . "@gmail.com";
        $data['password'] = Hash::make($request->nis);
        $data['level'] = 'siswa';

        // persiapan update user
        $userEdit = User::where('email',$siswa->email)->first();

        // update user siswa (tb_user)
        $userEdit = $userEdit->update([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['nis']),
            'level' => 'siswa',
        ]);

        // update siswa
        $siswaUpdate = $siswa->update($data);

        if ($siswaUpdate) {
            return redirect()->route('siswa.index')->with('success', 'data berhasil diedit');
        } else {
            return redirect()->back()->with('errpr', 'data gagal diedit');
        }
    }

    public function destroy(Siswa $siswa)
    {
        $siswaHapus = $siswa->delete();

        if ($siswaHapus) {
            return redirect()->route('siswa.index')->with('success', 'data berhasil dihapus');
        } else {
            return redirect()->back()->with('errpr', 'data gagal dihapus');
        }
    }
}
