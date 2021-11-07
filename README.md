# Laravel feature flag

Feature flags for a Laravel application

## Installation

This package can be installed via composer

```bash
  composer require jhacobs/laravel-feature-flag
```

Publish the config file

```bash
php artisan vendor:publish --provider="Jhacobs\FeatureFlag\FeatureFlagServiceProvider" --tag=config
```

## Usage/Examples

### Register features

You can register your app's features in the `feature-flag.php` config file.

```php
return [
    'production' => [
        'profile-banner' => false
    ],

    'acceptance' => [
        'profile-banner' => false
    ],

    'staging' => [
        'profile-banner' => true
    ],
];
```

### Get all feature flags

This package publishes an api route to get all the feature flags

```
REQUEST: api/feature-flags
RESPONSE: {
    data: {
        "production": {
            "profile-banner": false
        },
        "acceptance: {
            "profile-banner": false
        },
        "staging": {
            "profile-banner: true
        }
    }
}
```

### Feature flag middleware

You can use the `feature-flag` middleware to protect your routes with feature flags

```php
Route::get('profile-banner', [ProfileBannerController, 'index'])
    ->middleware('feature-flag:profile-banner');
```

## Running Tests

To run tests, run the following command

```bash
  composer test
```

## License

[MIT](https://choosealicense.com/licenses/mit/)
