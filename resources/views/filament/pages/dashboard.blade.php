<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header Dashboard --}}
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between text-white">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Dashboard SIGELAT</h1>
                    <p class="text-white/90">Sistem Informasi Gelar Alat - Monitoring & Manajemen</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-white/80">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                    <p class="text-2xl font-bold">{{ now()->format('H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($this->getWidgets() as $widget)
                @if ($widget === \App\Filament\Widgets\DashboardStatsWidget::class)
                    @livewire($widget)
                @endif
            @endforeach
        </div>

        {{-- Chart & Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Chart Area --}}
            <div class="lg:col-span-2">
                @foreach ($this->getWidgets() as $widget)
                    @if ($widget === \App\Filament\Widgets\GelarActivityChartWidget::class)
                        @livewire($widget)
                    @endif
                @endforeach
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <x-heroicon-o-rocket-launch class="w-5 h-5 text-primary-600" />
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('filament.admin.resources.gelars.create') }}" 
                           class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                            <x-heroicon-o-plus-circle class="w-6 h-6 text-green-600" />
                            <span class="font-medium text-green-700 dark:text-green-400">Buat Gelar Alat</span>
                        </a>
                        
                        <a href="{{ route('filament.admin.resources.alats.create') }}" 
                           class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                            <x-heroicon-o-wrench-screwdriver class="w-6 h-6 text-blue-600" />
                            <span class="font-medium text-blue-700 dark:text-blue-400">Tambah Alat</span>
                        </a>
                        
                        <a href="{{ route('filament.admin.resources.mobils.create') }}" 
                           class="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                            <x-heroicon-o-truck class="w-6 h-6 text-purple-600" />
                            <span class="font-medium text-purple-700 dark:dark:text-purple-400">Tambah Mobil</span>
                        </a>
                        
                        <a href="{{ route('filament.admin.resources.konfirmasi-gelars.index') }}" 
                           class="flex items-center gap-3 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition">
                            <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-amber-600" />
                            <span class="font-medium text-amber-700 dark:text-amber-400">Konfirmasi Laporan</span>
                        </a>
                    </div>
                </div>

                {{-- System Info --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-primary-600" />
                        System Info
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Laravel Version</span>
                            <span class="font-medium">{{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">PHP Version</span>
                            <span class="font-medium">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Filament Version</span>
                            <span class="font-medium">v3.x</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Database</span>
                            <span class="font-medium">MySQL</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity Table --}}
        <div>
            @foreach ($this->getWidgets() as $widget)
                @if ($widget === \App\Filament\Widgets\RecentActivityWidget::class)
                    @livewire($widget)
                @endif
            @endforeach
        </div>
    </div>
</x-filament-panels::page>