<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_kirim',
        'tanggal_terima',
        'no_surat',
        'isi_surat',
        'feedback_surat',
        'feedback_date',
        'dokumen_surat',
        'original_filename',
        'klasifikasi',
        'tipe_upload',
        'dokumen',

    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_terima' => 'date',
        'feedback_date' => 'date',

    ];

    public function pengirim()
    {
        return $this->belongsToMany(Institution::class, 'incoming_mails_pengirim');
    }

    public function penerima()
    {
        return $this->belongsToMany(Institution::class, 'incoming_mails_penerima');
    }
}
