# Filament Vertical Tabs

A Filament v3 package that adds vertical tabs functionality with a mobile-responsive interface.

## Features

- Vertical tabs layout for Filament forms
- Responsive design with mobile navigation
- Previous/next buttons for easy tab navigation on mobile
- Smooth transitions between tabs
- RTL support
- Dark mode support

## Requirements

- PHP 8.1+
- Laravel 11.0+
- Filament v3.0+

## Installation

You can install the package via Composer:

```bash
composer require afs19/filament-vertical-tabs
```

## Usage

### Basic Usage

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
        // Add more tabs as needed
    ]);
```

### Customization

You can publish the views for customization:

```bash
php artisan vendor:publish --tag=filament-vertical-tabs-views
```

## How It Works

This package adds a `vertical()` macro to Filament's Tabs component. When called, it:

1. Sets the tabs to use a vertical layout
2. Overrides the default Tabs view with a custom one that displays tabs vertically
3. Adds mobile responsiveness with a sliding panel for navigation

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.