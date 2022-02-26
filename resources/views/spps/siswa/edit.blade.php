@extends('layouts.app')

@section('activeSiswa')
    active
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item" aria-current="page">Siswa</li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    <h3>Edit Siswa</h3>

                    <div class="form p-2">
                        <form action="{{route('siswa.update',$siswa)}}" method="post">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nisn" value="{{old('nisn',$siswa->nisn)}}" id="nisn" class="form-control @error('nisn') invalid @enderror" placeholder="Masukan nisn" required readonly>

                                @error('nisn')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="number" maxlength="8" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nis" value="{{old('nis',$siswa->nis)}}" id="nis" class="form-control @error('nis') invalid @enderror" placeholder="Masukan nis" required>

                                @error('nis')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="nama">nama</label>
                                <input type="text" name="nama" value="{{old('nama',$siswa->nama)}}" id="nama" class="form-control @error('nama') invalid @enderror" placeholder="Masukan nama siswa" required>

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
                                        <option value="{{$kelas->id_kelas}}" {{$siswa->id_kelas == $kelas->id_kelas ? 'selected' : ''}}>{{$kelas->nama_kelas}}</option>
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
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan ALamat">{{old('alamat',$siswa->alamat)}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="no_telp">no_telp</label>
                                <input type="number" name="no_telp" value="{{old('no_telp',$siswa->no_telp)}}" id="no_telp" class="form-control @error('no_telp') invalid @enderror" placeholder="Masukan no telpon" required>

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
                                    <option value="{{$spp->id_spp}}" {{$siswa->id_spp == $spp->id_spp ? 'selected' : ''}}>Spp tahun : {{substr($spp->tahun,0,4)}} - {{substr($spp->tahun,0,4)}}</option>
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
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
