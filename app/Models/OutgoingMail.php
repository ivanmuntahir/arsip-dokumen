<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingMail extends Model
{
    protected $fillable = [
        'tanggal_kirim',
        'tanggal_terima',
        'no_surat',
        'isi_surat',
        'feedback_surat',
        'feedback_date',
        'tipe_upload',
        'dokumen_surat',
        'dokumen',

    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_terima' => 'date',
        'feedback_date' => 'date',
    ];

    public function pengirim()
    {
        return $this->belongsToMany(Institution::class, 'outgoing_mails_pengirim');
    }

    public function penerima()
    {
        return $this->belongsToMany(Institution::class, 'outgoing_mails_penerima');
    }
}
