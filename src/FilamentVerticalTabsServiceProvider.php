<?php

namespace Afs19\FilamentVerticalTabs;

use Filament\Forms\Components\Tabs as FormTabs;
use Filament\Infolists\Components\Tabs as InfolistTabs;
use Illuminate\Support\ServiceProvider;

class FilamentVerticalTabsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-vertical-tabs');
        
        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-vertical-tabs'),
        ], 'filament-vertical-tabs-views');

        // Register macro for Form Tabs
        FormTabs::macro('vertical', function (bool $isVertical = true) {
            $this->viewData([
                'isVertical' => $isVertical,
            ]);

            if ($isVertical) {
                $this->view('filament-vertical-tabs::vertical-tabs');
            }

            return $this;
        });

        // Register macro for Infolist Tabs
        InfolistTabs::macro('vertical', function (bool $isVertical = true) {
            $this->viewData([
                'isVertical' => $isVertical,
            ]);

            if ($isVertical) {
                $this->view('filament-vertical-tabs::vertical-tabs');
            }

            return $this;
        });
    }
}
