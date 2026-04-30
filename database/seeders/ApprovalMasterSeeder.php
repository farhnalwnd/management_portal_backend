<?php

namespace Database\Seeders;

use App\Models\ApprovalMaster;
use Illuminate\Database\Seeder;

class ApprovalMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApprovalMaster::factory(1)->create([
            'approver_id' => 1,
            'level' => 1,
        ]);
    }
}
