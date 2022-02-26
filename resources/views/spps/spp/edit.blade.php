@extends('layouts.app')

@section('activeSpp')
    active
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item" aria-current="page">SPP</li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    <h3>Edit SPP</h3>

                    <div class="form p-2">
                        <form action="{{route('spp.update',$spp)}}" method="post">
                            @csrf
                            @method('put')

                             <div class="form-group">
                                <label for="nama_spp">Tahun</label>
                                <input type="number" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="tahun" value="{{old('tahun',substr($spp->tahun,0,4))}}" id="tahun" class="form-control @error('tahun') invalid @enderror" placeholder="Masukan tahun contoh format : (2020)" required>

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
                                <label for="nama_spp">Nominal</label>
                                <input type="number" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="nominal" value="{{old('nominal',$spp->nominal)}}" id="nominal" class="form-control @error('nominal') invalid @enderror" placeholder="Masukan nominal spp" required>

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
            </div>
        </div>
    </div>
</div>



@endsection
