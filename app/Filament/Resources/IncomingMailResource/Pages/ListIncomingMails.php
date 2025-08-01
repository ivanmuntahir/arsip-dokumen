<?php

namespace App\Filament\Resources\IncomingMailResource\Pages;

use App\Filament\Resources\IncomingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;

class ListIncomingMails extends ListRecords
{
    protected static string $resource = IncomingMailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Surat Masuk Baru')
                ->icon('tabler-octagon-plus'),
            // Actions\ButtonAction::make('Export Laporan')
            // ->url(fn()=> route('download.laporan'))->openUrlInNewTab(),
            Action::make('Export Laporan')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->modalHeading('Pilih Periode Export Laporan')
                ->modalSubmitActionLabel('Export PDF')
                ->form([
                    DatePicker::make('start_date')
                        ->label('Tanggal Mulai')
                        ->required()
                        ->default(now()->startOfMonth()),
                    DatePicker::make('end_date')
                        ->label('Tanggal Akhir')
                        ->required()
                        ->default(now()),
                ])
                ->action(function (array $data) {
                    $startDate = $data['start_date'];
                    $endDate = $data['end_date'];

                    return redirect()->route('download.laporan.surat.masuk.filtered', [
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]);
                }),


        ];
    }
}
