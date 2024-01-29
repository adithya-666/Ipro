<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nama_pegawai');
            $table->string('nik_pegawai');
            $table->string('nomor_kk');
            $table->string('email');
            $table->string('email_kantor');
            $table->string('departemen');
            $table->string('unit_bisnis');
            $table->string('golongan');
            $table->string('jabatan');
            $table->string('golongan_asli');
            $table->string('cabang');
            $table->string('kendaraan');
            $table->string('status_pegawai');
            $table->date('tanggal_masuk');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('golongan_darah');
            $table->text('alamat');
            $table->integer('no_telepon')->length(15);
            $table->integer('no_rekening')->length(25);
            $table->string('tingkat_pendidikan');
            $table->string('status_pendidikan');
            $table->string('nama_pasangan');
            $table->string('jumlah_anak');
            $table->string('nama_ayah');
            $table->string('nomor_telpon_keluarga');
            $table->string('foto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
