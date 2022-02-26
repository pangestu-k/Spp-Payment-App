@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Siswa</li>
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

                    <h3>Halaman Siswa</h3>

                    <div class="button-tambah mt-4 mb-3 ml-3">
                        <button type="button" class="btn btn-success modalbutton" data-toggle="modal" data-target="#siswaModal">
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
                                  <th scope="col">Nisn</th>
                                  <th scope="col">Nis</th>
                                  <th scope="col">Nama Siswa</th>
                                  <th scope="col">Kelas</th>
                                  <th scope="col">No telp</th>
                                  <th scope="col">Spp</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>

                          @php
                              $no = 0;
                          @endphp
                          <tbody>
                              @forelse ($siswaAll as $siswa)
                                <tr>
                                    <td scope="col">{{++$no}}</td>
                                    <td scope="col">{{$siswa->nisn}}</td>
                                    <td scope="col">{{$siswa->nis}}</td>
                                    <td scope="col">{{ Str::limit($siswa->nama,20,'...')}}</td>
                                    <td scope="col">{{$siswa->kelas->nama_kelas}}</td>
                                    <td scope="col">{{$siswa->no_telp}}</td>
                                    <td scope="col"><b>Spp</b> tahun {{substr($siswa->spp->tahun,0,4)}} - {{substr($siswa->spp->tahun,-4,4)}}</td>
                                    <td scope="col">
                                        <form onsubmit="return confirm('Yakin anda ingin menghapus {{$siswa->nama_siswa}} ?');" action="{{route('siswa.destroy',$siswa)}}" method="post">
                                            @csrf
                                            @method('delete')

                                            <a href="{{route('siswa.edit',$siswa)}}" style="color: white" class="btn btn-warning"><i class="fas fa-edit"></i></a>

                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="9" style="color: whitesmoke" class="bg-danger text-bold text-center">Belum terdapat data apapaun <i class="fas fa-sad-cry"></i></td>
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

<div id="siswaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Data Siswa</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if ($sppAll->count() == 0 || $kelasAll->count() == 0)
                    <h3>Anda harus melengkapi dulu data kelas ataupun data siswa</h3>
                @else
                    <div class="form">
                        <form action="{{route('siswa.store')}}" onsubmit="return confirm('Periksa kembali Nisn karna nisn tidak bisa diubah kembali ! Yakin Sudah sesuai ?');" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="text" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nisn" value="{{old('nisn')}}" id="nisn" class="form-control number @error('nisn') invalid @enderror" placeholder="Masukan nisn [ min 8 karakter ]" required>

                                @error('nisn')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" maxlength="8" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nis" value="{{old('nis')}}" id="nis" class="form-control number @error('nis') invalid @enderror" placeholder="Masukan nis [ min 8 karakter ]" required>

                                @error('nis')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="nama">nama</label>
                                <input type="text" name="nama" value="{{old('nama')}}" id="nama" class="form-control @error('nama') invalid @enderror" placeholder="Masukan nama siswa" required>

                                @error('nama')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="id_kelas">Kelas</label>
                                <select name="id_kelas" id="id_kelas" class="form-control">
                                    @foreach ($kelasAll as $kelas)
                                        <option value="{{$kelas->id_kelas}}">{{$kelas->nama_kelas}}</option>
                                    @endforeach
                                </select>

                                @error('id_kelas')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan ALamat">{{old('alamat')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="no_telp">no_telp</label>
                                <input type="number" name="no_telp" value="{{old('no_telp')}}" id="no_telp" class="form-control @error('no_telp') invalid @enderror" placeholder="Masukan no telpon" required>

                                @error('no_telp')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="id_spp">spp</label>
                                <select name="id_spp" class="form-control" id="id_spp">
                                    @foreach ($sppAll as $spp)
                                    <option value="{{$spp->id_spp}}">Spp tahun : {{substr($spp->tahun,0,4)}} - {{substr($spp->tahun,-4)}}</option>
                                    @endforeach
                                </select>

                                @error('id_spp')
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
                @endif
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

<script>
    $('.nisn').keyup(function(){
        var sanitized = $(this).val().replace(/[^0-9]/g, '');

        $(this).val(sanitized);
    });
    $('.nis').keyup(function(){
        var sanitized = $(this).val().replace(/[^0-9]/g, '');

        $(this).val(sanitized);
    });
    $('.number').keyup(function(){
        var sanitized = $(this).val().replace(/[^0-9]/g, '');

        $(this).val(sanitized);
    });
</script>
@endsection
