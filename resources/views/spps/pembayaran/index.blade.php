@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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


                    <h3>Halaman Pembayaran</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">
                        <a href="{{route('pembayaran.create')}}" class="btn btn-success modalbutton">
                            <small>
                                Tambah <i class="fa fa-plus" aria-hidden="true"></i>
                            </small>
                        </a>

                        <a href="{{route('pembayaran.export')}}" class="btn btn-dark ml-2">
                            <small>
                                Export <i class="fas fa-file-excel    "></i>
                            </small>
                        </a>

                    </div>

                    <div class="table">
                      <table class="table table-hover" id="table_id">
                          <thead>
                              <tr>
                                  <th scope="col">No</th>
                                  <th scope="col">Nama</th>
                                  <th scope="col">Nisn</th>
                                  <th scope="col">Petugas</th>
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
                              @forelse ($pembayaranAll as $pembayaran)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{$pembayaran->siswa->nama}}</td>
                                    <td scope="col">{{$pembayaran->nisn}}</td>
                                    <td scope="col">{{$pembayaran->petugas->nama_petugas}}</td>
                                    <td scope="col">{{$pembayaran->tgl_bayar}}</td>
                                    <td scope="col">{{$pembayaran->bulan_dibayar}}</td>
                                    <td scope="col">{{$pembayaran->tahun_dibayar}}</td>
                                    <td scope="col"><b>Spp </b>{{substr($pembayaran->spp->tahun,0,4)}} -{{substr($pembayaran->spp->tahun,-4,4)}}</td>
                                    <td scope="col"><b>Rp. </b>{{number_format($pembayaran->jumlah_bayar)}}</td>
                                    <td scope="col">
                                        <form onsubmit="return confirm('Yakin anda ingin menghapus {{$pembayaran->nama_pembayaran}} ?');" action="{{route('pembayaran.destroy',$pembayaran)}}" method="post">
                                            @csrf
                                            @method('delete')

                                            <a href="{{route('pembayaran.edit',$pembayaran)}}" style="color: white" class="btn btn-warning mb-2">Edit <i class="fas fa-edit"></i></a>

                                            <a href="{{route('pembayaran.show',$pembayaran)}}" class="btn btn-primary">
                                                Lihat <i class="fa fa-street-view" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" class="btn btn-danger mt-2">
                                                Hapus <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
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
