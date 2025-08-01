<?php

namespace App\Filament\Resources\OutgoingMailResource\Pages;

use App\Filament\Resources\OutgoingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOutgoingMail extends CreateRecord
{
    protected static string $resource = OutgoingMailResource::class;
}
