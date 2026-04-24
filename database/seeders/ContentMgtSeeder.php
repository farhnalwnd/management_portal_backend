<?php

namespace Database\Seeders;

use App\Models\ContentMgt;
use Illuminate\Database\Seeder;

class ContentMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'type' => 'catera',
                'title' => 'catera',
                'modul_id' => 1,
                'version' => 'v2',
                'status' => true,
                'repo' => 'http://localhost:81',
                'created_by' => 1,
                'last_modified_by' => 1,
                'published_by' => 1,
                'published_date' => '2026-04-14',
                'approver_id' => 1,
                'approval_status' => 'approved',
                'deleted_at' => null,
                'created_at' => '2026-04-14 02:19:08',
                'updated_at' => '2026-04-14 02:19:08',
            ],
            [
                'type' => 'portal',
                'title' => 'portal',
                'modul_id' => 2,
                'version' => 'v-1',
                'status' => true,
                'repo' => 'http://localhost:80',
                'created_by' => 1,
                'last_modified_by' => 1,
                'published_by' => 1,
                'published_date' => '2026-04-16',
                'approver_id' => 1,
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
