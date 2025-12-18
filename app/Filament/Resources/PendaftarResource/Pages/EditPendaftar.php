<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendaftar extends EditRecord
{
    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus Data')
                ->modalHeading('Hapus Pendaftar')
                ->modalDescription('Apakah Anda yakin ingin menghapus data pendaftar ini?'),
            
            // Actions\Action::make('view')
            //     ->label('Lihat Detail')
            //     ->url(fn () => $this->getResource()::getUrl('view', ['record' => $this->record]))
            //     ->icon('heroicon-o-eye')
            //     ->color('gray'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data pendaftar berhasil diperbarui';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}