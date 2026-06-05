# Filament Vertical Tabs

A Filament package that adds mobile-responsive vertical tabs functionality.

## Features

- Vertical tabs layout for Filament forms and infolists
- Responsive design with mobile navigation (slide-out panel)
- Previous/next buttons for easy tab navigation on mobile
- Smooth transitions between tabs
- RTL support
- Dark mode support

## Requirements

- PHP 8.1+ (3.x) / PHP 8.2+ (4.x)
- Laravel 11.0+ (3.x) / Laravel v11.28+ (4.x)
- Filament v3.0+ (3.x) / Filament v4.0+ (4.x)

## Installation

You can install the package via Composer:

```bash
composer require afs19/filament-vertical-tabs
```

Composer will automatically select the correct branch for your Filament version.

## Usage

### Filament v3

```php
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

Tabs::make('Settings')
    ->vertical() // This activates the vertical tabs layout
    ->tabs([
        Tab::make('General')
            ->icon('heroicon-o-cog')
            ->schema([
                // Your form components here
            ]),
        Tab::make('Notifications')
            ->icon('heroicon-o-bell')
            ->schema([
                // Your form components here
            ]),
    ]);
```

### Filament v4

```php
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

Tabs::make('Settings')
    ->verticalMobile() // This activates the mobile-responsive vertical tabs layout
    ->tabs([
        Tab::make('General')
            ->icon('heroicon-o-cog')
            ->schema([
                // Your form components here
            ]),
        Tab::make('Notifications')
            ->icon('heroicon-o-bell')
            ->schema([
                // Your form components here
            ]),
    ]);
```

### Customization

You can publish the views for customization:

```bash
php artisan vendor:publish --tag=filament-vertical-tabs-views
```

## How It Works

### Filament v3

This package adds a `vertical()` macro to Filament's Tabs component. When called, it:
1. Sets the tabs to use a vertical layout
2. Overrides the default Tabs view with a custom one that displays tabs vertically
3. Adds mobile responsiveness with a sliding panel for navigation

### Filament v4

Filament v4 ships a native `vertical()` method. This package extends it with the `verticalMobile()` macro which calls the native `vertical()` and overrides the view to provide the mobile-responsive experience (hamburger menu, slide-out panel, prev/next buttons).

> **Tailwind CSS v4 note:** If you use this package's custom Blade view with Filament v4, you must have a [custom theme](https://filamentphp.com/docs/4.x/appearance/themes) that adds a `@source` pointing to this package's `resources/views/` directory so that Tailwind picks up the utility classes used in the view.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
