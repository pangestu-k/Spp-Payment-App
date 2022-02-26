@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Petugas</li>
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

                    <h3>Halaman Petugas</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">
                        <button type="button" class="btn btn-success modalbutton" data-toggle="modal" data-target="#petugasModal">
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
                                  <th scope="col">Nama Petugas</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Password</th>
                                  <th scope="col">Level</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>

                          @php
                              $no = 0;
                          @endphp
                          <tbody>
                              @forelse ($petugasAll as $petugas)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{$petugas->nama_petugas}}</td>
                                    <td scope="col">{{$petugas->email}}</td>
                                    <td scope="col">{{Str::limit($petugas->password, 10, '...')}}</td>
                                    <td scope="col">{{$petugas->level}}</td>
                                    <td scope="col">
                                        <form onsubmit="return confirm('Yakin anda ingin menghapus {{$petugas->nama_petugas}} ?');" action="{{route('petugas.destroy',$petugas)}}" method="post">
                                            @csrf
                                            @method('delete')

                                            <a href="{{route('petugas.edit',$petugas)}}" style="color: white" class="btn btn-warning"><i class="fas fa-edit"></i></a>

                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6" style="color: whitesmoke" class="bg-danger text-bold text-center">Belum terdapat data apapaun <i class="fas fa-sad-cry"></i></td>
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

<div id="petugasModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Data Petugas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form action="{{route('petugas.store')}}" method="post">
                        @csrf

                         <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="{{old('username')}}" id="username" class="form-control @error('username') invalid @enderror" placeholder="Masukan Username petugas" required >

                            @error('username')

                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                         </div>

                         <div class="form-group">
                            <label for="nama_petugas">nama_petugas</label>
                            <input type="text" name="nama_petugas" value="{{old('nama_petugas')}}" id="nama_petugas" class="form-control @error('nama_petugas') invalid @enderror" placeholder="Masukan nama_petugas petugas" required >

                            @error('nama_petugas')

                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                         </div>

                         <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{old('email')}}" id="email" class="form-control @error('email') invalid @enderror" placeholder="Masukan akunEmail@gmail.com" required>

                            @error('email')
                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                         </div>

                         <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="{{old('password')}}" id="password" class="form-control @error('password') invalid @enderror" placeholder="Masukan password" required>

                            @error('password')
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
