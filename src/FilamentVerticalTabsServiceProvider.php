<?php

namespace Afs19\FilamentVerticalTabs;

use Filament\Schemas\Components\Tabs;
use Illuminate\Support\ServiceProvider;

class FilamentVerticalTabsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-vertical-tabs');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-vertical-tabs'),
        ], 'filament-vertical-tabs-views');

        Tabs::macro('verticalMobile', function (bool $isVertical = true) {
            $this->vertical($isVertical);

            if ($isVertical) {
                $this->view('filament-vertical-tabs::vertical-tabs');
            }

            return $this;
        });
    }
}
