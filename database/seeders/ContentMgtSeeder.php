<?php

namespace Database\Seeders;

use App\Models\ContentMgt;
use App\Models\ModulMgt;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContentMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::take(2)->get();
        $createdBy = $users->first()?->id ?? User::factory()->create()->id;

        $cateraModule = ModulMgt::query()->where('module_name', 'catera')->first();
        $portalModule = ModulMgt::query()->where('module_name', 'portal')->first();

        $cateraModuleId = $cateraModule?->id ?? 1;
        $portalModuleId = $portalModule?->id ?? 2;

        $contents = [
            [
                'type' => 'catera',
                'title' => 'catera',
                'modul_id' => $cateraModuleId,
                'version' => 'v2',
                'status' => true,
                'repo' => 'http://localhost:81',
                'created_by' => $createdBy,
                'last_modified_by' => $createdBy,
                'published_by' => $createdBy,
                'published_date' => '2026-04-14',
                'approver_id' => $createdBy,
                'approval_status' => 'approved',
                'deleted_at' => null,
                'created_at' => '2026-04-14 02:19:08',
                'updated_at' => '2026-04-14 02:19:08',
            ],
            [
                'type' => 'portal',
                'title' => 'portal',
                'modul_id' => $portalModuleId,
                'version' => 'v-1',
                'status' => true,
                'repo' => 'http://localhost:80',
                'created_by' => $createdBy,
                'last_modified_by' => $createdBy,
                'published_by' => $createdBy,
                'published_date' => '2026-04-16',
                'approver_id' => $createdBy,
                'approval_status' => 'approved',
                'deleted_at' => null,
                'created_at' => '2026-04-16 14:31:35',
                'updated_at' => '2026-04-16 14:31:35',
            ],
        ];

        foreach ($contents as $content) {
            ContentMgt::create($content);
        }
    }
}
