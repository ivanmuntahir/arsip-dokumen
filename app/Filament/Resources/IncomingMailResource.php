<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingMailResource\Pages;
use App\Filament\Resources\IncomingMailResource\RelationManagers;
use App\Models\IncomingMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use Filament\Infolists\Infolist;
use Closure;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Storage;


class IncomingMailResource extends Resource
{
    protected static ?string $model = IncomingMail::class;

    protected static ?string $navigationLabel = 'Surat Masuk';
    protected static ?string $navigationGroup = 'Manajemen Surat';
    protected static ?string $navigationIcon = 'tabler-mail-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pengirim')
                    ->label('Instansi Pengirim')
                    ->multiple()
                    ->relationship('pengirim', 'nama')
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('penerima')
                    ->label('Instansi Penerima')
                    ->multiple()
                    ->relationship('penerima', 'nama')
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_kirim')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_terima')
                    ->required(),
                Forms\Components\TextInput::make('no_surat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('isi_surat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('feedback_surat')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('feedback_date'),
                Forms\Components\Select::make('klasifikasi')
                    ->label('Klasifikasi Surat')
                    ->options([
                        'biasa' => 'BIASA',
                        'segera' => 'SEGERA',
                        'sangat_segera' => 'SANGAT SEGERA',
                    ])
                    ->reactive(),
                Forms\Components\Select::make('tipe_upload')
                    ->label('Platform Pengiriman')
                    ->options([
                        'mail' => 'MAIL',
                        'wa' => 'WHATSAPP',
                        'lainnya' => 'LAINNYA',
                    ])
                    ->reactive(),
                Forms\Components\FileUpload::make('dokumen_surat')
                    ->label('Dokumen Surat')
                    ->directory('surat-masuk')
                    ->storeFileNamesIn('original_filename')
                    ->required(),
                Forms\Components\FileUpload::make('dokumen')
                    ->label('Dokumen Bukti Pengiriman')
                    ->directory('bukti-upload-surat-masuk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_terima')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('isi_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedback_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedback_date')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('dokumen_surat')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('dokumen_surat') // 'file_pdf' adalah nama kolom di database Anda
                //     ->label('File PDF')
                //     ->url(fn (string $state): string => asset('storage/' . $state)) // Menggabungkan base URL dengan path dari DB
                //     ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Nama File Asli'),
                Tables\Columns\IconColumn::make('dokumen_surat')
                    ->label('File Surat')
                    ->icon('heroicon-o-document-text') // Ganti dengan icon yang sesuai
                    ->url(fn (string $state): string => asset('storage/' . $state))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('PDF Viewer')
                ->description('Prevent the PDF from being downloaded')
                ->collapsible()
                ->schema([
                    PdfViewerEntry::make('dokumen_surat')
                        ->label('View the PDF')
                        ->minHeight('40svh')
                        ->fileUrl(Storage::url('dummy.pdf')) // Set the file url if you are getting a pdf without database
                        ->columnSpanFull()
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomingMails::route('/'),
            'create' => Pages\CreateIncomingMail::route('/create'),
            'edit' => Pages\EditIncomingMail::route('/{record}/edit'),
        ];
    }
}
