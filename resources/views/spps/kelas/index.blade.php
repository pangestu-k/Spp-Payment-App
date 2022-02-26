@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Kelas</li>
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

                    <h3>Halaman Kelas</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">
                        <button type="button" class="btn btn-success modalbutton" data-toggle="modal" data-target="#kelasModal">
                            <small>
                                Tambah <i class="fa fa-plus" aria-hidden="true"></i>
                            </small>
                        </button>


                    </div>

                    <div class="table">
                      <table class="table table-hover" id="table_id">
                          <thead>
                              <tr>
                                  <th scope="col">No</th>
                                  <th scope="col">Nama Kelas</th>
                                  <th scope="col">Kompetensi Keahlian</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>

                          @php
                              $no = 0;
                          @endphp
                          <tbody>
                              @forelse ($kelasAll as $kelas)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{$kelas->nama_kelas}}</td>
                                    <td scope="col">{{$kelas->kompetensi_keahlian}}</td>
                                    <td scope="col">
                                        <form onsubmit="return confirm('Yakin anda ingin menghapus {{$kelas->nama_kelas}} ?');" action="{{route('kelas.destroy',$kelas)}}" method="post">
                                            @csrf
                                            @method('delete')

                                            <a href="{{route('kelas.edit',$kelas)}}" style="color: white" class="btn btn-warning"><i class="fas fa-edit"></i></a>

                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="4" style="color: whitesmoke" class="bg-danger text-bold text-center">Belum terdapat data apapaun <i class="fas fa-sad-cry"></i></td>
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

<div id="kelasModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Data Kelas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form action="{{route('kelas.store')}}" method="post">
                        @csrf

                         <div class="form-group">
                            <label for="nama_kelas">Nama kelas</label>
                            <input type="text" name="nama_kelas" value="{{old('nama_kelas')}}" id="nama_kelas" class="form-control @error('nama_kelas') invalid @enderror" placeholder="Masukan nama kelas" required >

                            @error('nama_kelas')

                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                         </div>

                         <div class="form-group">
                            <label for="kompetensi_keahlian">Kompetensi keahlian</label>
                            <input type="text" name="kompetensi_keahlian" value="{{old('kompetensi_keahlian')}}" id="kompetensi_keahlian" class="form-control @error('kompetensi_keahlian') invalid @enderror" placeholder="Masukan nama jurusan" required>

                            @error('kompetensi_keahlian')
                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                         </div>

                         <div class="form-group">
                             <button type="submit" class="btn btn-primary">
                                 Simpan
                             </button>
                         </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <i class="fas fa-user-astronaut"></i>
                <i>Created by &copy; Pangestu-k</i>
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
