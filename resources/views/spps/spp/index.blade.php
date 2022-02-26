@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">SPP</li>
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

                    @if (Session::get('tnominal'))
                        <div class="alert alert-danger mt-2 mb-2" role="alert">
                            {{Session::get('tnominal')}}
                        </div>
                    @endif

                    <h3>Halaman SPP</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">
                        <button type="button" class="btn btn-success modalbutton" data-toggle="modal" data-target="#sppModal">
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
                                  <th scope="col">Tahun Belajar</th>
                                  <th scope="col">Nominal</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>

                          @php
                              $no = 0;
                          @endphp
                          <tbody>
                              @forelse ($sppAll as $spp)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{substr($spp->tahun,0,4)}} - {{substr($spp->tahun,-4,4)}}</td>
                                    <td scope="col"><b>Rp. </b>{{number_format($spp->nominal)}}</td>
                                    <td scope="col">
                                        <form onsubmit="return confirm('Yakin anda ingin menghapus Spp tahun ajar {{substr($spp->tahun,0,4)}} - {{substr($spp->tahun,-4,4)}} ?');" action="{{route('spp.destroy',$spp)}}" method="post">
                                            @csrf
                                            @method('delete')

                                            <a href="{{route('spp.edit',$spp)}}" style="color: white" class="btn btn-warning"><i class="fas fa-edit"></i></a>

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

<div id="sppModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Data SPP</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form action="{{route('spp.store')}}" method="post">
                        @csrf

                         <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="number" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="tahun" value="{{old('tahun')}}" id="tahun" class="form-control @error('tahun') invalid @enderror" placeholder="Masukan tahun contoh format : (2020)" required>

                            @error('tahun')

                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                            @if (Session::get('error'))
                                <div class="error p-2" style="color: red">
                                    {{Session::get('error')}}
                                </div>
                            @endif

                         </div>

                         <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nominal" value="{{old('nominal')}}" id="nominal" class="form-control @error('nominal') invalid @enderror" placeholder="Masukan nominal spp" required>

                            @error('nominal')

                                <div class="error p-2" style="color: red">
                                    {{$message}}
                                </div>
                            @enderror

                            @if (Session::get('tnominal'))
                                <div class="error p-2" style="color: red">
                                    {{Session::get('tnominal')}}
                                </div>
                            @endif

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
