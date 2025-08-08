<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use Carbon\Carbon;
use Filament\Support\Colors\Color;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {

       $startDate = $this->filters['startDate'] ? Carbon::parse($this->filters['startDate']) : now()->startOfMonth();
        $endDate = $this->filters['endDate'] ? Carbon::parse($this->filters['endDate']) : now()->endOfMonth();

        // 2. Gunakan query builder yang lebih efisien untuk menghitung surat
        $suratMasukCount = IncomingMail::query()
            ->whereBetween('tanggal_kirim', [$startDate, $endDate])
            ->count();

        $suratKeluarCount = OutgoingMail::query()
            ->whereBetween('tanggal_kirim', [$startDate, $endDate])
            ->count();

        // 3. Contoh penambahan stat lain, misalnya berdasarkan klasifikasi
        $suratMasukKlasifikasiBiasa = IncomingMail::query()
            ->whereBetween('tanggal_kirim', [$startDate, $endDate])
            ->where('klasifikasi', 'biasa')
            ->count();

        $suratMasukKlasifikasiSegera = IncomingMail::query()
            ->whereBetween('tanggal_kirim', [$startDate, $endDate])
            ->where('klasifikasi', 'segera')
            ->count();

        $suratMasukKlasifikasiSangatSegera = IncomingMail::query()
            ->whereBetween('tanggal_kirim', [$startDate, $endDate])
            ->where('klasifikasi', 'sangat_segera')
            ->count();

        return [
            Stat::make('Total Surat Masuk', $suratMasukCount)
                ->description('Jumlah surat masuk yang telah diterima')
                ->color('success'),
            Stat::make('Total Surat Keluar', $suratKeluarCount)
                ->description('Jumlah surat keluar yang telah dikirim')
                ->color('warning'),
            Stat::make('Surat Masuk (Biasa)', $suratMasukKlasifikasiBiasa)
                ->description('Jumlah surat masuk dengan klasifikasi biasa'),
            Stat::make('Surat Masuk (Segera)', $suratMasukKlasifikasiSegera)
                ->description('Jumlah surat masuk dengan klasifikasi segera')
                ->color(Color::Cyan),
            Stat::make('Surat Masuk (Sangat Segera)', $suratMasukKlasifikasiSangatSegera)
                ->description('Jumlah surat masuk dengan klasifikasi sangat segera')
                ->color('danger'),
        ];
    }
}
