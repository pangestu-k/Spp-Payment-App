<?php

namespace App\Http\Controllers;

use App\Exports\PembayaranExport;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PembayaranController extends Controller
{

    /*
                                  "notice"
                                ============
        karna aplikasi ini dibuat saat ujian dengan waktu yg terbatas dan
        harus mengejar validasi data yang benar-benar ketat dan maksimal,
        jadi banyak kode yang kurang efektif, tapi projek ini fleksibel
        dan memungkinkan untuk di kembangkan terutama di controller
        pembayaran, bisa kalian bikin se oop mungkin, karna di projek
        ini masih banyak 'repeatation code'.
    */

    public function index()
    {
        $petugas = Petugas::where('email', '=', auth()->user()->email)->first();

        if ($petugas == null) {
            Petugas::create([
                'username' => auth()->user()->name,
                'email' => auth()->user()->level . '@gmail.com',
                'password' => Hash::make(auth()->user()->level),
                'nama_petugas' => auth()->user()->name,
                'level' => 'admin'
            ]);
        }

        $pembayaranAll = Pembayaran::latest()->orderBy('id_pembayaran', 'Desc')->paginate(36);
        return view('spps.pembayaran.index', compact('pembayaranAll'));
    }

    public function create()
    {
        $siswaAll = Siswa::all();
        return view('spps.pembayaran.create', compact('siswaAll'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nisn' => 'required|numeric',
            'jumlah_bayar' => 'required|numeric',
        ]);

        if ($request->bayar_berapa == 1) {
            for ($i = 0; $i < $request->bayar_berapa; $i++) {
                $idPetugas = Petugas::where('email', '=', auth()->user()->email)->first();
                $bulan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

                $siswa = Siswa::where('nisn', '=', $request->nisn)->first();
                $spp = Spp::where('id_spp', '=', $siswa->id_spp)->first();
                $pembayaran = Pembayaran::where('nisn', '=', $siswa->nisn)->get();

                if ($pembayaran->isEmpty()) {
                    $bln = 6;
                    $tahun = substr($spp->tahun, 0, 4);
                } else {
                    $pembayaran = Pembayaran::where('nisn', '=', $siswa->nisn)
                        ->orderBy('id_pembayaran', 'Desc')->latest()
                        ->first();

                    $bln = array_search($pembayaran->bulan_dibayar, $bulan);

                    if ($bln == 11) {
                        $bln = 0;
                        $tahun = $pembayaran->tahun_dibayar + 1;
                    } else {
                        $bln = $bln + 1;
                        $tahun = $pembayaran->tahun_dibayar;
                    }

                    if ($pembayaran->tahun_dibayar == substr($spp->tahun, -4, 4) && $pembayaran->bulan_dibayar == 'desember') {
                        return back()->with('error', 'sudah lunas');
                    }
                }

                if ($request->jumlah_bayar < $spp->nominal) {
                    return back()->with('tjumlah_bayar', 'Uang yang dimasukan tidak sesuai');
                }

                $pembayaranSimpan = Pembayaran::create([
                    'id_petugas' => $idPetugas->id_petugas,
                    'nisn' => $request->nisn,
                    'tgl_bayar' => Carbon::now()->timezone('asia/jakarta'),
                    'bulan_dibayar' => $bulan[$bln],
                    'tahun_dibayar' => $tahun,
                    'id_spp' => $spp->id_spp,
                    'jumlah_bayar' => $request->jumlah_bayar
                ]);
            }
        } else {
            for ($i = 1; $i <= $request->bayar_berapa; $i++) {
                $idPetugas = Petugas::where('email', '=', auth()->user()->email)->first();
                $bulan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

                $siswa = Siswa::where('nisn', '=', $request->nisn)->first();
                $spp = Spp::where('id_spp', '=', $siswa->id_spp)->first();
                $pembayaran = Pembayaran::where('nisn', '=', $siswa->nisn)->get();

                if ($pembayaran->isEmpty()) {
                    $bln = 6;
                    $tahun = substr($spp->tahun, 0, 4);
                } else {
                    $pembayaran = Pembayaran::where('nisn', '=', $siswa->nisn)
                        ->orderBy('id_pembayaran', 'Desc')->latest()
                        ->first();

                    $bln = array_search($pembayaran->bulan_dibayar, $bulan);

                    if ($bln == 11) {
                        $bln = 0;
                        $tahun = $pembayaran->tahun_dibayar + 1;
                    } else {
                        $bln = $bln + 1;
                        $tahun = $pembayaran->tahun_dibayar;
                    }

                    if ($pembayaran->tahun_dibayar == substr($spp->tahun, -4, 4) && $pembayaran->bulan_dibayar == 'desember') {
                        return back()->with('error', 'sudah lunas');
                    }
                }

                if ($request->jumlah_bayar < $spp->nominal) {
                    return back()->with('tjumlah_bayar', 'Uang yang dimasukan tidak sesuai');
                }

                if ($i == $request->bayar_berapa && $request->jumlah_bayar == $spp->nominal) {
                    $pembayaranSimpan = Pembayaran::create([
                        'id_petugas' => $idPetugas->id_petugas,
                        'nisn' => $request->nisn,
                        'tgl_bayar' => Carbon::now()->timezone('asia/jakarta'),
                        'bulan_dibayar' => $bulan[$bln],
                        'tahun_dibayar' => $tahun,
                        'id_spp' => $spp->id_spp,
                        'jumlah_bayar' => $spp->nominal
                    ]);
                } elseif ($i == $request->bayar_berapa) {
                    $pembayaranSimpan = Pembayaran::create([
                        'id_petugas' => $idPetugas->id_petugas,
                        'nisn' => $request->nisn,
                        'tgl_bayar' => Carbon::now()->timezone('asia/jakarta'),
                        'bulan_dibayar' => $bulan[$bln],
                        'tahun_dibayar' => $tahun,
                        'id_spp' => $spp->id_spp,
                        'jumlah_bayar' => $request->jumlah_bayar - $spp->nominal * ($request->bayar_berapa - 1)
                    ]);
                }
                else {
                    $pembayaranSimpan = Pembayaran::create([
                        'id_petugas' => $idPetugas->id_petugas,
                        'nisn' => $request->nisn,
                        'tgl_bayar' => Carbon::now()->timezone('asia/jakarta'),
                        'bulan_dibayar' => $bulan[$bln],
                        'tahun_dibayar' => $tahun,
                        'id_spp' => $spp->id_spp,
                        'jumlah_bayar' => $spp->nominal
                    ]);
                }
            }
        }


        if ($pembayaranSimpan) {
            return redirect()->route('pembayaran.index')->with('success', 'data berhasil masuk');
        } else {
            return redirect()->back()->with('error', 'data gagal masuk');
        }
    }

    public function edit(Pembayaran $pembayaran)
    {
        $siswaAll = Siswa::all();
        return view('spps.pembayaran.edit', compact('pembayaran', 'siswaAll'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $this->validate($request, [
            'nisn' => 'required|numeric',
            'bulan_dibayar' => 'required',
            'tahun_dibayar' => 'required',
            'jumlah_bayar' => 'required|numeric',
        ]);

        $data = $request->all();

        $pembayaranUpdate = $pembayaran->update($data);

        if ($pembayaranUpdate) {
            return redirect()->route('pembayaran.index')->with('success', 'data berhasil diedit');
        } else {
            return redirect()->back()->with('errpr', 'data gagal diedit');
        }
    }

    public function show(Pembayaran $pembayaran)
    {
        return view('spps.pembayaran.show', compact('pembayaran'));
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaranHapus = $pembayaran->delete();

        if ($pembayaranHapus) {
            return redirect()->route('pembayaran.index')->with('success', 'data berhasil dihapus');
        } else {
            return redirect()->back()->with('errpr', 'data gagal dihapus');
        }
    }

    public function excelExport()
    {

        $nama = 'Pembayaran-' . date(now()) . '.xlsx';
        return (new PembayaranExport)->download($nama);
    }

    public function getData($nisn, $berapa)
    {
        $siswa = Siswa::where('nisn', '=', $nisn)->first();
        $spp = Spp::where('id_spp', '=', $siswa->id_spp)->first();
        $pembayaran = Pembayaran::where('nisn', '=', $nisn)
            ->orderBy('id_pembayaran', 'Desc')->latest()
            ->first();


        if ($pembayaran == null) {
            $data = [
                'nominal' => $spp->nominal * $berapa,
                'bulan' => 'belum pernah bayar',
                'tahun' => '',
            ];
        } else {

            if ($pembayaran->tahun_dibayar == substr($spp->tahun, -4, 4) && $pembayaran->bulan_dibayar == 'juni') {
                $data = [
                    'nominal' => $spp->nominal * $berapa,
                    'bulan' => 'sudah lunas',
                    'tahun' => '',
                ];
            } else {
                $data = [
                    'nominal' => $spp->nominal * $berapa,
                    'bulan' => $pembayaran->bulan_dibayar,
                    'tahun' => $pembayaran->tahun_dibayar,
                ];
            }
        }

        return response()->json($data);
    }

    public function history()
    {

        if (auth()->user()->level == 'siswa') {
            $siswa = Siswa::where('email', '=', auth()->user()->email)->first();
            $historyAll = Pembayaran::where('nisn', '=', $siswa->nisn)->get();
        } else {
            $historyAll = Pembayaran::all();
        }

        return view('spps.pembayaran.history', compact('historyAll'));
    }
}
