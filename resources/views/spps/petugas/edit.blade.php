@extends('layouts.app')

@section('activePetugas')
    active
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item" aria-current="page">petugas</li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    <h3>Edit Petugas</h3>

                    <div class="form p-2">
                        <form action="{{route('petugas.update',$petuga)}}" method="post">
                            @csrf
                            @method('put')

                             <div class="form-group">
                                <label for="nama_petugas">Username</label>
                                <input type="text" name="username" value="{{old('username',$petuga->username)}}" id="username" class="form-control @error('username') invalid @enderror" placeholder="Masukan Username petugas" required >

                                @error('username')

                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                             </div>

                             <div class="form-group">
                                <label for="nama_petugas">Nama petugas</label>
                                <input type="text" name="nama_petugas" value="{{old('nama_petugas',$petuga->nama_petugas)}}" id="nama_petugas" class="form-control @error('nama_petugas') invalid @enderror" placeholder="Masukan akunnama_petugas@gmail.com" required>

                                @error('nama_petugas')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                             </div>

                             <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{old('email',$petuga->email)}}" id="email" class="form-control @error('email') invalid @enderror" placeholder="Masukan akunEmail@gmail.com" required>

                                @error('email')
                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                             </div>

                             <div class="form-group">
                                <label for="password">Password <span class="text-secondary">(isi jika ingin mengganti)</span> </label>
                                <input type="password" name="password" value="{{old('password')}}" id="password" class="form-control @error('password') invalid @enderror" placeholder="Masukan akunpassword@gmail.com">

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
            </div>
        </div>
    </div>
</div>



@endsection
