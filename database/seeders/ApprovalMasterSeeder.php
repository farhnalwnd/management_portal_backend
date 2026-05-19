<?php

namespace Database\Seeders;

use App\Models\ApprovalMaster;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApprovalMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create();

        ApprovalMaster::factory(1)->create([
            'approver_id' => $user->id,
            'level' => 1,
        ]);
    }
}
