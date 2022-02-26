<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;


class PembayaranExport implements FromView
{

    use Exportable;


    public function view(): View
    {
        if (auth()->user()->level == 'siswa') {
            $pembayaranAll = Pembayaran::where('email', '=', auth()->user()->email)->get();
        } else {
            $pembayaranAll = Pembayaran::all();
        }
        return view('spps.pembayaran.excel.export', [
            'pembayaranAll' => $pembayaranAll,
        ]);
    }
}
