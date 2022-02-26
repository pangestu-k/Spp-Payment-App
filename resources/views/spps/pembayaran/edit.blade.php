@extends('layouts.app')

@section('activePembayaran')
    active
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item" aria-current="page">pembayaran</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">

                    @if (Session::get('tjumlah_bayar'))
                        <div class="alert alert-danger mt-2 mb-2" role="alert">
                            {{Session::get('tjumlah_bayar')}}
                        </div>
                    @endif

                    @if (Session::get('error'))
                    <div class="alert alert-danger mt-2 mb-2" role="alert">
                        {{Session::get('error')}}
                    </div>
                @endif

                    <h3>Pembayaran</h3>

                    <div class="form p-2">
                        <form action="{{route('pembayaran.update',$pembayaran)}}" class="mt-3" method="post">
                            @csrf
                            @method('put')

                            @if ($siswaAll->count() == 0)
                                <div class="form-group">
                                    <input type="text" class="form-control" style="background-color: red" value="Belum ada kelas anda harus input kelas dulu">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <select name="nisn" id="nisn" style="width: 100%">
                                        <option disabled selected>== Pilih Siswa ==</option>
                                        @foreach ($siswaAll as $siswa)
                                            <option value="{{$siswa->nisn}}" {{$pembayaran->nisn == $siswa->nisn ? 'selected' : ''}}>{{$siswa->nama}}</option>
                                        @endforeach
                                    </select>

                                    @error('nisn')

                                        <div class="error p-2" style="color: red">
                                            {{$message}}
                                        </div>
                                    @enderror

                                </div>
                            @endif

                            <div class="form-group">
                                <label for="bulan_dibayar">Bulan dibayar</label>
                                <select name="bulan_dibayar" id="bulan_dibayar"  class="form-control" required>
                                    <option value="januari"  {{$pembayaran->bulan_dibayar == "januari" ? 'selected' : ''}}>Januari</option>
                                    <option value="februari"  {{$pembayaran->bulan_dibayar == "februari" ? 'selected' : ''}}>februari</option>
                                    <option value="maret"  {{$pembayaran->bulan_dibayar == "maret" ? 'selected' : ''}}>maret</option>
                                    <option value="april"  {{$pembayaran->bulan_dibayar == "april" ? 'selected' : ''}}>april</option>
                                    <option value="mei"  {{$pembayaran->bulan_dibayar == "mei" ? 'selected' : ''}}>mei</option>
                                    <option value="juni"  {{$pembayaran->bulan_dibayar == "juni" ? 'selected' : ''}}>juni</option>
                                    <option value="juli"  {{$pembayaran->bulan_dibayar == "juli" ? 'selected' : ''}}>juli</option>
                                    <option value="agustus"  {{$pembayaran->bulan_dibayar == "agustus" ? 'selected' : ''}}>agustus</option>
                                    <option value="september"  {{$pembayaran->bulan_dibayar == "september" ? 'selected' : ''}}>september</option>
                                    <option value="oktober"  {{$pembayaran->bulan_dibayar == "oktober" ? 'selected' : ''}}>oktober</option>
                                    <option value="november"  {{$pembayaran->bulan_dibayar == "november" ? 'selected' : ''}}>november</option>
                                    <option value="desember"  {{$pembayaran->bulan_dibayar == "desember" ? 'selected' : ''}}>desember</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tahun_dibayar">Tahun dibayar</label>
                                <input type="number" name="tahun_dibayar" id="tahun_dibayar" value="{{$pembayaran->tahun_dibayar}}" class="form-control" required>
                            </div>


                             <div class="form-group">
                                <label for="jumlah_bayar">jumlah_bayar</label>
                                <input type="number" min="20000" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="jumlah_bayar" value="{{old('jumlah_bayar',$pembayaran->jumlah_bayar)}}" id="jumlah_bayar" class="form-control @error('jumlah_bayar') invalid @enderror" placeholder="Masukan jumlah_bayar spp" required>

                                @error('jumlah_bayar')

                                    <div class="error p-2" style="color: red">
                                        {{$message}}
                                    </div>
                                @enderror

                                @if (Session::get('tjumlah_bayar'))
                                    <div class="error p-2" style="color: red">
                                        {{Session::get('tnominal')}}
                                    </div>
                                @endif

                             </div>

                                @if ($siswaAll->count() == 0)
                                    <div class="form-group">
                                        <a href="{{route('pembayaran.index')}}" class="btn btn-dark">
                                            Back <i class="fa fa-fire-extinguisher" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <button type="submit" id="buttonSubmit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </div>
                                @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#nisn').select2();
    });
</script>

<script>
    $('#nisn').on('change', function(){
        var nisn = $('#nisn').val();
        console.log(nisn);

        $.ajax({
            url: "{{url('pembayaran/getData/')}}" + "/" + nisn,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);

                if(data['bulan'] == "sudah lunas"){
                    var waktu = data['bulan'] + " " + data["tahun"];
                    $('#nominal').val(data['nominal']);
                    $('#waktuTerakhir').val(waktu);

                    $('#jumlah_bayar').prop('readonly','true');
                    $('#buttonSubmit').prop('disabled','true');
                }else{
                    var waktu = data['bulan'] + " " + data["tahun"];
                    $('#nominal').val(data['nominal']);
                    $('#waktuTerakhir').val(waktu);

                    $('#jumlah_bayar').removeAttr('readonly','true');
                    $('#buttonSubmit').removeAttr('disabled', 'true');
                }


            }
        });
    });
</script>

<script>
    $('#jumlah_bayar').keyup(function(){
        var sanitized = $(this).val().replace(/[^0-9]/g, '');

        $(this).val(sanitized);
    });
</script>



@endsection
