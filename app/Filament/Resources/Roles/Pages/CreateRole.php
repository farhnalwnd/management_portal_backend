<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateRole extends CreateRecord
{
    use indexDirect;

    protected static string $resource = RoleResource::class;

    public array $permissionIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'permissions_')) {
                if (is_array($value)) {
                    $this->permissionIds = array_merge($this->permissionIds, $value);
                }
                unset($data[$key]);
            }
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncPermissions($this->permissionIds);

        $webhookUrl = config('services.catera.webhook_url');
        $webhookSecret = config('services.catera.webhook_secret');

        if (empty($webhookUrl) || empty($webhookSecret)) {
            Log::warning('Webhook Catera tidak dikirim: URL atau Secret tidak dikonfigurasi.');

            return;
        }

        try {
            Http::withHeaders([
                'X-Secret-Token' => $webhookSecret,
            ])->post($webhookUrl.'/api/webhook/clear-permission-cache');
            Log::info('Webhook Catera berhasil');
        } catch (\Exception $e) {
            Log::error('Webhook Catera gagal: '.$e->getMessage());
        }
    }
}
