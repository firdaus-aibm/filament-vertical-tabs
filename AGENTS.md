# AGENTS.md

## What this is

A Filament v3 package (`afs19/filament-vertical-tabs`) that adds a `vertical()` macro to `Filament\Forms\Components\Tabs` and `Filament\Infolists\Components\Tabs`.

## Structure

- **Namespace**: `Afs19\FilamentVerticalTabs\` → `src/`
- **Entrypoint**: `src/FilamentVerticalTabsServiceProvider.php` — registers both macros + loads Blade views
- **View namespace**: `filament-vertical-tabs::` → `resources/views/`
- **Only Blade view**: `vertical-tabs.blade.php` (referenced as `filament-vertical-tabs::vertical-tabs`)
- **Publish tag**: `php artisan vendor:publish --tag=filament-vertical-tabs-views`

## Requirements

- PHP 8.1+, Laravel 12.x, Filament 3.x

## Quirks

- `composer.lock` is gitignored (unusual for a library — don't generate one or commit it)
- No tests, no CI, no linting/formatting config exist — do not add or expect them
