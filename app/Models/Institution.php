<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function incomingMailsSent(): BelongsToMany
    {
        return $this->belongsToMany(IncomingMail::class, 'incoming_mails_pengirim');
    }

    public function incomingMailsReceived(): BelongsToMany
    {
        return $this->belongsToMany(IncomingMail::class, 'incoming_mails_penerima');
    }

    public function outgoingMailsSent(): BelongsToMany
    {
        return $this->belongsToMany(OutgoingMail::class, 'outgoing_mail_pengirim');
    }

    public function outgoingMailsReceived(): BelongsToMany
    {
        return $this->belongsToMany(OutgoingMail::class, 'outgoing_mail_penerima');
    }
}
