<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftar extends CreateRecord
{
    protected static string $resource = PendaftarResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pendaftar berhasil ditambahkan';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Anda bisa memodifikasi data sebelum disimpan di sini
        // Contoh: $data['created_by'] = auth()->id();
        
        return $data;
    }
}