<?php

namespace Database\Seeders;

use App\Models\ApprovalMaster;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
