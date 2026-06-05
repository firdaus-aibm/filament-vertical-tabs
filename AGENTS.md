# AGENTS.md

## What this is

A Filament package (`afs19/filament-vertical-tabs`) that adds mobile-responsive vertical tabs.
Maintained on two branches:

- **`main`** — targets `filament/filament:^3.0`, `php:^8.1`. Macro name: `vertical()`.
- **`4.x`** — targets `filament/filament:^4.0`, `php:^8.2`. Macro name: `verticalMobile()`.

## Structure

- **Namespace**: `Afs19\FilamentVerticalTabs\` → `src/`
- **Entrypoint**: `src/FilamentVerticalTabsServiceProvider.php` — registers macros + loads Blade views
- **View namespace**: `filament-vertical-tabs::` → `resources/views/`
- **Only Blade view**: `vertical-tabs.blade.php` (referenced as `filament-vertical-tabs::vertical-tabs`)
- **Publish tag**: `php artisan vendor:publish --tag=filament-vertical-tabs-views`

## Requirements

| Branch | PHP | Laravel | Filament |
|---|---|---|---|
| `main` | ^8.1 | ^11.0 \|\| ^12.0 \|\| ^13.0 | ^3.0 |
| `4.x`  | ^8.2 | ^11.28 \|\| ^12.0 \|\| ^13.0 | ^4.0 |
| `5.x`  | ^8.2 | ^11.28 \|\| ^12.0 \|\| ^13.0 | ^5.0 |

## Quirks

- `composer.lock` is gitignored (unusual for a library — don't generate one or commit it)
- No tests, no CI, no linting/formatting config exist — do not add or expect them
- On `4.x`, the macro calls the native `->vertical()` then overrides the view; it does NOT override a real method
- On `4.x`, the Tabs component is in `Filament\Schemas\Components\Tabs` (unified, not separate Form/Infolist classes)
