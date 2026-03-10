<?php

namespace Database\Seeders;

use App\Models\ModulMgt;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /** @var array<int, string> */
    private const FEATURES = [
        'dashboard',
        'report',
        'employee',
        'attendance',
        'payroll',
        'module',
        'user',
        'menu',
        'content',
        'approval',
    ];

    /** @var array<int, string> */
    private const ACTIONS = ['view', 'create', 'edit', 'delete', 'export', 'import', 'approve'];

    public function run(): void
    {
        // 10 Global permissions (module_id = null)
        $globalCombinations = $this->getUniqueCombinations(10);
        foreach ($globalCombinations as [$feature, $action]) {
            Permission::firstOrCreate([
                'name' => "global:{$feature}:{$action}",
                'guard_name' => 'web',
            ]);
        }

        // 40 Module-specific permissions
        $modules = ModulMgt::where('is_active', true)->get();

        if ($modules->isEmpty()) {
            $this->command->warn('No active modules found. Skipping module-specific permissions.');

            return;
        }

        $moduleCombinations = $this->getUniqueCombinations(40);
        foreach ($moduleCombinations as $index => [$feature, $action]) {
            $module = $modules[$index % $modules->count()];

            Permission::firstOrCreate([
                'name' => "{$module->module_name}:{$feature}:{$action}",
                'guard_name' => 'web',
                'module_id' => $module->id,
            ]);
        }
    }

    /**
     * Generate unique feature:action combinations.
     *
     * @return array<int, array{string, string}>
     */
    private function getUniqueCombinations(int $count): array
    {
        $combinations = [];
        $seen = [];

        while (count($combinations) < $count) {
            $feature = self::FEATURES[array_rand(self::FEATURES)];
            $action = self::ACTIONS[array_rand(self::ACTIONS)];
            $key = "{$feature}:{$action}";

            if (! isset($seen[$key])) {
                $seen[$key] = true;
                $combinations[] = [$feature, $action];
            }
        }

        return $combinations;
    }
}
