<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'kode_pasien',
        'nama_inisial',
        'usia',
        'jenis_kelamin',
        'tanggal_masuk_icu',
        'diagnosis_medis_utama',
        'status_kesadaran',
        'kemampuan_komunikasi',
        'nama_perawat_pengisi',
        'tanggal_pengisian',
        'sadar',
        'mampu_berkomunikasi',
        'memahami_pertanyaan',
        'bersedia_assessment',
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk_icu' => 'date',
        'tanggal_pengisian' => 'date',
        'sadar' => 'boolean',
        'mampu_berkomunikasi' => 'boolean',
        'memahami_pertanyaan' => 'boolean',
        'bersedia_assessment' => 'boolean',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}