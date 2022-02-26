<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_petugas')->constrained('table_petugas', 'id_petugas')->onDelete('cascade');
            $table->char('nisn', 10)->index();
            $table->date('tgl_bayar');
            $table->string('bulan_dibayar', 15);
            $table->string('tahun_dibayar', 15);
            $table->foreignId('id_spp')->constrained('table_spp', 'id_spp')->onDelete('cascade');
            $table->integer('jumlah_bayar');
            $table->timestamps();

            $table->foreign('nisn')
                ->references('nisn')
                ->on('table_siswa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_pembayaran');
    }
}
