<?php

namespace Afs19\FilamentVerticalTabs;

use Filament\Forms\Components\Tabs;
use Illuminate\Support\ServiceProvider;

class FilamentVerticalTabsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-vertical-tabs');
        
        // Make views publishable
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-vertical-tabs'),
        ], 'filament-vertical-tabs-views');

        // Register the macro
        Tabs::macro('vertical', function (bool $isVertical = true) {
            $this->viewData([
                'isVertical' => $isVertical,
            ]);

            // override the view only if vertical
            if ($isVertical) {
                $this->view('filament-vertical-tabs::vertical-tabs');
            }

            return $this;
        });
    }
}