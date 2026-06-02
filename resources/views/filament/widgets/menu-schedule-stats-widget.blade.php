<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Menu Schedule Progress Overview
        </x-slot>

        <x-slot name="afterHeader">
            <select wire:model.live="filter" class="text-xs font-medium border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 py-1.5 pl-3 pr-8">
                @foreach ($this->getFilters() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </x-slot>

        <div class="space-y-6 py-4">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Scheduled Menus</span>
                    <h3 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mt-1">{{ $total }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($stats as $stat)
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $stat['label'] }}</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $stat['count'] }} <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">({{ $stat['percentage'] }}%)</span>
                            </span>
                        </div>
                        
                        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2.5 overflow-hidden">
                            <div class="{{ $stat['color'] }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $stat['percentage'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
