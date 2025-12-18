<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftarResource\Pages;
use App\Filament\Resources\PendaftarResource\RelationManagers;
use Filament\Notifications\Notification;
use App\Models\Pendaftar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftarResource extends Resource
{
    protected static ?string $model = Pendaftar::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Pendaftar';

    protected static ?string $modelLabel = 'Pendaftar';

    protected static ?string $pluralModelLabel = 'Data Pendaftar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormSchema());
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Data Pribadi')
                ->description('Informasi pribadi calon peserta didik')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->placeholder('Masukkan nama lengkap')
                        ->helperText('Isi sesuai dengan akta kelahiran atau KTP')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->placeholder('Pilih tanggal lahir')
                        ->helperText('Format: DD/MM/YYYY')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->maxDate(now()),

                    Forms\Components\Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->placeholder('Pilih jenis kelamin')
                        ->helperText('Pilih jenis kelamin sesuai identitas')
                        ->required()
                        ->options([
                            'laki' => 'Laki-laki',
                            'perempuan' => 'Perempuan',
                        ]),

                    Forms\Components\TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->placeholder('Masukkan kota tempat lahir')
                        ->helperText('Contoh: Jakarta, Bandung, Surabaya')
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Asal Sekolah')
                ->description('Informasi sekolah asal calon peserta didik')
                ->schema([
                    Forms\Components\TextInput::make('nama_sekolah')
                        ->label('Nama Sekolah')
                        ->placeholder('Masukkan nama sekolah lengkap')
                        ->helperText('Contoh: SMP Negeri 1 Jakarta, SMA Negeri 2 Bandung')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('alamat_sekolah')
                        ->label('Alamat Sekolah')
                        ->placeholder('Masukkan alamat lengkap sekolah')
                        ->helperText('Isi dengan jalan, kelurahan, kecamatan, kota, dan kode pos')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Data Orang Tua / Wali')
                ->description('Informasi orang tua atau wali calon peserta didik')
                ->schema([
                    Forms\Components\TextInput::make('nama_panjang_ortu')
                        ->label('Nama Lengkap Orang Tua/Wali')
                        ->placeholder('Masukkan nama lengkap orang tua/wali')
                        ->helperText('Nama sesuai KTP orang tua/wali')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('profesi_ortu')
                        ->label('Profesi/Pekerjaan Orang Tua/Wali')
                        ->placeholder('Masukkan profesi atau pekerjaan')
                        ->helperText('Contoh: PNS, Wiraswasta, Dokter, Guru, dll')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('telepon_orang_tua')
                        ->label('Nomor Telepon/WhatsApp Orang Tua/Wali')
                        ->placeholder('Contoh: 081234567890')
                        ->helperText('Nomor yang dapat dihubungi (WA aktif)')
                        ->required()
                        ->tel()
                        ->maxLength(20)
                        ->prefix('+62')
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),

                    Forms\Components\Textarea::make('alamat_ortu')
                        ->label('Alamat Orang Tua/Wali')
                        ->placeholder('Masukkan alamat lengkap orang tua/wali')
                        ->helperText('Alamat tempat tinggal saat ini')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Tambahan')
                ->description('Informasi tambahan untuk keperluan administrasi')
                ->schema([
                    Forms\Components\Textarea::make('alamat_pribadi')
                        ->label('Alamat Tempat Tinggal Saat Ini')
                        ->placeholder('Masukkan alamat tempat tinggal saat ini')
                        ->helperText('Jika berbeda dengan alamat orang tua, isi alamat tempat tinggal peserta didik')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\Select::make('program_pilihan')
                        ->label('Program yang Dipilih')
                        ->placeholder('Pilih program pendidikan')
                        ->helperText('Pilih program sesuai kebutuhan belajar')
                        ->required()
                        ->options([
                            'Reguler' => 'Reguler (Kelas reguler)',
                            'Intensif' => 'Intensif (Kelas khusus)',
                        ])
                        ->native(false),

                    Forms\Components\TextInput::make('dari_siapa')
                        ->label('Mendengar Informasi dari')
                        ->placeholder('Masukkan sumber informasi pendaftaran')
                        ->helperText('Contoh: Teman, Guru, Spanduk, Instagram, Facebook, dll')
                        ->required()
                        ->maxLength(255),
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'laki' => 'primary',
                        'perempuan' => 'warning',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'laki' => 'Laki-Laki',
                        'perempuan' => 'Perempuan',
                    }),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('program_pilihan')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'reguler' => 'info',
                        'intensif' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'reguler' => "Reguler",
                        'intensif' => "Intensif",
                    }),

                Tables\Columns\TextColumn::make('telepon_orang_tua')
                    ->label('Telepon Ortu')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('is_verified')
                    ->label('Sudah Bayar')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        '0' => 'warning',
                        '1' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => 'Sudah',
                        '0' => 'Belum',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Didaftarkan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('is_verified')
                    ->label('Pembayaran')
                    ->options([
                        '1' => 'Sudah',
                        '0' => 'Belum',
                    ]),

                Tables\Filters\SelectFilter::make('program_pilihan')
                    ->options([
                        'Reguler' => 'Reguler',
                        'Intensif' => 'Intensif',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('verify')
                        ->label(
                            fn($record) =>
                            $record->is_verified ? 'Batalkan Verifikasi' : 'Verifikasi'
                        )
                        ->icon(
                            fn($record) =>
                            $record->is_verified
                            ? 'heroicon-o-x-circle'
                            : 'heroicon-o-shield-check'
                        )
                        ->color(
                            fn($record) =>
                            $record->is_verified ? 'warning' : 'success'
                        )
                        ->requiresConfirmation()
                        ->modalHeading(
                            fn($record) =>
                            $record->is_verified
                            ? 'Batalkan Verifikasi Pembayaran'
                            : 'Verifikasi Pembayaran'
                        )
                        ->modalDescription(
                            fn($record) =>
                            $record->is_verified
                            ? 'Apakah Anda yakin ingin membatalkan verifikasi pembayaran Pendaftar ini?'
                            : 'Apakah Anda yakin ingin memverifikasi pembayaran Pendaftar ini?'
                        )
                        ->modalSubmitActionLabel(
                            fn($record) =>
                            $record->is_verified ? 'Ya, Batalkan' : 'Ya, Verifikasi'
                        )
                        ->modalIcon(
                            fn($record) =>
                            $record->is_verified
                            ? 'heroicon-o-exclamation-triangle'
                            : 'heroicon-o-check-circle'
                        )
                        ->modalIconColor(
                            fn($record) =>
                            $record->is_verified ? 'warning' : 'success'
                        )
                        ->action(function ($record) {
                            $record->update([
                                'is_verified' => !$record->is_verified,
                            ]);

                            Notification::make()
                                ->icon(
                                    $record->is_verified
                                    ? 'heroicon-o-check-circle'
                                    : 'heroicon-o-exclamation-triangle'
                                )
                                ->iconColor(
                                    $record->is_verified ? 'success' : 'warning'
                                )
                                ->title(
                                    $record->is_verified
                                    ? 'Pembayaran berhasil diverifikasi'
                                    : 'Verifikasi pembayaran dibatalkan'
                                )
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verifySelected')
                        ->label('Verifikasi Pembayaran')
                        ->icon('heroicon-o-shield-check')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Verifikasi Pembayaran')
                        ->modalDescription('Apakah Anda yakin ingin memverifikasi pembayaran Pendaftar yang dipilih?')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_verified' => true,
                                ]);
                            }
                            Notification::make()
                                ->title('Pembayaran berhasil diverifikasi')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('cancelSelected')
                        ->label('Batalkan Verifikasi')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Verifikasi Pembayaran')
                        ->modalDescription('Apakah Anda yakin ingin membatalkan verifikasi pembayaran Pendaftar yang dipilih?')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_verified' => false,
                                ]);
                            }
                            Notification::make()
                                ->title('Verifikasi pembayaran dibatalkan')
                                ->warning()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\BulkAction::make('export')
                    //     ->label('Export Data')
                    //     ->icon('heroicon-o-arrow-down-tray')
                    //     ->action(fn($records) => self::exportData($records)),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relations jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftars::route('/'),
            'create' => Pages\CreatePendaftar::route('/create'),
            'edit' => Pages\EditPendaftar::route('/{record}/edit'),
        ];
    }

    private static function exportData($records)
    {
        // Implementasi export data
        // Anda bisa menggunakan package seperti Maatwebsite/Laravel-Excel
    }
}