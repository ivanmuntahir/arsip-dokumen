<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'instansi_pengirim_id',
        'tanggal_kirim',
        'instansi_penerima_id',
        'tanggal_terima',
        'no_surat',
        'isi_surat',
        'feedback_surat',
        'feedback_date',
        'dokumen_surat',
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_terima' => 'date',
        'feedback_date' => 'date',
    ];

    public function InstansiPengirim(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'instansi_pengirim_id');
    }

    public function InstansiPenerima(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'instansi_penerima_id');
    }
}
