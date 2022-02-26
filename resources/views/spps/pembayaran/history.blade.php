@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    @if (Session::get('success'))
                        <div class="alert alert-success mt-2 mb-2" role="alert">
                            {{Session::get('success')}}
                        </div>
                    @endif

                    @if (Session::get('error'))
                        <div class="alert alert-danger mt-2 mb-2" role="alert">
                            {{Session::get('error')}}
                        </div>
                    @endif


                    <h3>Halaman History</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">


                        @if (auth()->user()->level == 'admin' || auth()->user()->level == 'petugas')
                            <a href="{{route('pembayaran.export')}}" class="btn btn-dark ml-2">
                                <small>
                                    Export <i class="fas fa-file-excel    "></i>
                                </small>
                            </a>
                        @endif

                    </div>

                    <div class="table">
                      <table class="table table-hover" id="table_id">
                          <thead>
                              <tr>
                                  <th scope="col">No</th>
                                  <th scope="col">Petugas</th>
                                  <th scope="col">Nisn</th>
                                  <th scope="col">Nama</th>
                                  <th scope="col">Tanggal</th>
                                  <th scope="col">Bulan dibayar</th>
                                  <th scope="col">Tahun dibayar</th>
                                  <th scope="col">Spp</th>
                                  <th scope="col">Jumlah Bayar</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>

                          @php
                              $no = 0;
                          @endphp
                          <tbody>
                              @forelse ($historyAll as $history)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{$history->petugas->nama_petugas}}</td>
                                    <td scope="col">{{$history->nisn}}</td>
                                    <td scope="col">{{$history->siswa->nama}}</td>
                                    <td scope="col">{{$history->tgl_bayar}}</td>
                                    <td scope="col">{{$history->bulan_dibayar}}</td>
                                    <td scope="col">{{$history->tahun_dibayar}}</td>
                                    <td scope="col"><b>Spp </b>{{substr($history->spp->tahun,0,4)}} -{{substr($history->spp->tahun,-4,4)}}</td>
                                    <td scope="col"><b>Rp. </b>{{number_format($history->jumlah_bayar)}}</td>
                                    <td scope="col">

                                            <a href="{{route('pembayaran.show',$history)}}" class="btn btn-primary">
                                                Lihat <i class="fa fa-street-view" aria-hidden="true"></i>
                                            </a>

                                        </form>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="10" style="color: whitesmoke" class="bg-danger text-bold text-center">Belum terdapat data apapaun <i class="fas fa-sad-cry"></i></td>
                                </tr>
                              @endforelse
                          </tbody>
                      </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
    });
</script>


@endsection
