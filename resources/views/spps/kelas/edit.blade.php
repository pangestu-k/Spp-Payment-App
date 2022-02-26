@extends('layouts.app')

@section('activeKelas')
    active
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item" aria-current="page">kelas</li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    <h3>Edit Kelas</h3>

                    <div class="form p-2">
                        <form action="{{route('kelas.update',$kela)}}" class="mt-3" method="post">
                            @csrf

                            @method('put')

                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" value="{{old('nama_kelas',$kela->nama_kelas)}}" id="nama_kelas" class="form-control @error('nama_kelas') invalid @enderror" placeholder="Masukan nama kelas" >

                                    @error('nama_kelas')

                                        <div class="error p-2" style="color: red">
                                            {{$message}}
                                        </div>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="kompetensi_keahlian">Kompetensi keahlian</label>
                                    <input type="text" name="kompetensi_keahlian" value="{{old('kompetensi_keahlian',$kela->kompetensi_keahlian)}}" id="kompetensi_keahlian" class="form-control @error('kompetensi_keahlian') invalid @enderror" placeholder="Masukan nama jurusan" >

                                    @error('kompetensi_keahlian')
                                        <div class="error p-2" style="color: red">
                                            {{$message}}
                                        </div>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Update
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
