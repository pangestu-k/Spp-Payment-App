@extends('layouts.app')

@section('activePembayaran')
    active
@endsection

@section('content')
<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card p-4" onclick="window.print()">

                <div class="card-header">
                    <i class="fas fa-user-astronaut fa-5x float-left mr-4"></i>
                    <h3>SMK Langit Bersejarah</h3>
                    <h3>Spp Payment - Aplikasi Penghitung Spp</h3>
                </div>

                <div class="card-body">

                    <div class="div float-right">
                         {{$pembayaran->created_at->format('Y M d')}}
                    </div>

                    <div class="div">
                        <b>Nisn :</b>&nbsp;&nbsp;&nbsp;{{$pembayaran->nisn}}
                    </div>

                    <div class="div">
                        <b>Nama :</b>&nbsp;&nbsp;&nbsp;{{$pembayaran->siswa->nama}}
                    </div>

                    <div class="div">
                        <b>Rombel :</b>&nbsp;&nbsp;&nbsp;{{$pembayaran->siswa->kelas->nama_kelas}}
                    </div>

                    <div class="div">
                        <b>Bulan dibayar :</b>&nbsp;&nbsp;&nbsp;{{$pembayaran->bulan_dibayar}}
                    </div>

                    <div class="div">
                        <b>Tahun dibayar :</b>&nbsp;&nbsp;&nbsp;{{$pembayaran->tahun_dibayar}}
                    </div>

                    <div class="div">
                        <b>Jumlah Bayar :</b>&nbsp;&nbsp;&nbsp; Rp. {{number_format($pembayaran->jumlah_bayar) . ",00"}}
                    </div>

                </div>

                <div class="card-footer text-center">
                    <i class="fas fa-user-astronaut"></i>
                    <i>Created by &copy; Pangestu-k</i>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
