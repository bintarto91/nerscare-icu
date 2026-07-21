<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pasien')->unique();
            $table->string('nama_inisial');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_masuk_icu')->nullable();
            $table->string('diagnosis_medis_utama')->nullable();
            $table->string('status_kesadaran')->nullable();
            $table->string('kemampuan_komunikasi')->nullable();
            $table->string('nama_perawat_pengisi')->nullable();
            $table->date('tanggal_pengisian')->nullable();

            $table->boolean('sadar')->default(false);
            $table->boolean('mampu_berkomunikasi')->default(false);
            $table->boolean('memahami_pertanyaan')->default(false);
            $table->boolean('bersedia_assessment')->default(false);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};