<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutgoingMailResource\Pages;
use App\Filament\Resources\OutgoingMailResource\RelationManagers;
use App\Models\OutgoingMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutgoingMailResource extends Resource
{
    protected static ?string $model = OutgoingMail::class;

    protected static ?string $navigationLabel = 'Surat Keluar';
    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?string $navigationIcon = 'tabler-mail-up';

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
                    ->required(),
                Forms\Components\TextInput::make('feedback_surat')
                    // ->columnSpanFull()
                    ,
                Forms\Components\DatePicker::make('feedback_date'),
                Forms\Components\FileUpload::make('dokumen_surat')
                    ->label('Dokumen Surat')
                    ->directory('surat-keluar')
                    ->preserveFilenames()
                    ->required(),
                Forms\Components\Select::make('tipe_upload')
                    ->label('Platform Pengiriman')
                    ->options([
                        'mail' => 'Mail',
                        'wa' => 'Whatsapp',
                        'lainnya' => 'Lainnya',
                    ])
                    ->reactive(),
                Forms\Components\FileUpload::make('dokumen')
                    ->label('Dokumen Pendukung')
                    ->directory('bukti-upload-surat-keluar')
                    ->preserveFilenames()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_kirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_terima')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedback_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipe_upload')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dokumen_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dokumen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hash_file')
                    ->searchable(),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListOutgoingMails::route('/'),
            'create' => Pages\CreateOutgoingMail::route('/create'),
            'edit' => Pages\EditOutgoingMail::route('/{record}/edit'),
        ];
    }
}
