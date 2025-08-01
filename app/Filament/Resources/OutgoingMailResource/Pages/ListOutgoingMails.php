<?php

namespace App\Filament\Resources\OutgoingMailResource\Pages;

use App\Filament\Resources\OutgoingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutgoingMails extends ListRecords
{
    protected static string $resource = OutgoingMailResource::class;
    protected static ?string $title = 'Data Surat Keluar';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Surat Keluar Baru')
                ->icon('tabler-octagon-plus'),
        ];
    }
}
