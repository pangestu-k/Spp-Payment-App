<table class="table table-hover" id="table_id">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Petugas</th>
            <th scope="col">Nisn</th>
            <th scope="col">Nama</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Bulan dibayar</th>
            <th scope="col">Tahun dibayar</th>
            <th scope="col">Spp</th>
            <th scope="col">Jumlah Bayar</th>
        </tr>
    </thead>

    @php
        $no = 0;
    @endphp
    <tbody>
        @forelse ($pembayaranAll as $pembayaran)
          <tr>
              <td scope="col">{{++$no}}</td>
              <td scope="col">{{$pembayaran->petugas->nama_petugas}}</td>
              <td scope="col">{{$pembayaran->nisn}}</td>
              <td scope="col">{{$pembayaran->siswa->nama}}</td>
              <td scope="col">{{$pembayaran->tgl_bayar}}</td>
              <td scope="col">{{$pembayaran->bulan_dibayar}}</td>
              <td scope="col">{{$pembayaran->tahun_dibayar}}</td>
              <td scope="col"><b>Spp </b>{{substr($pembayaran->spp->tahun,0,4)}} -{{substr($pembayaran->spp->tahun,-4,4)}}</td>
              <td scope="col">{{$pembayaran->jumlah_bayar}}</td>
          </tr>
        @empty
          <tr>
              <td colspan="9" style="color: black" class="bg-danger text-bold text-center">Belum terdapat data apapaun <i class="fas fa-sad-cry"></i></td>
          </tr>
        @endforelse
    </tbody>
</table>
