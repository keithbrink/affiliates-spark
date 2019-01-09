# AffiliatesSpark

An affiliates package for [Laravel Spark](https://spark.laravel.com/) that allows you to track referrals from affiliates and pay commission.

## Installation

This version requires [PHP](https://php.net) 7, and supports Laravel 5.5+ and Spark 5+.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require keithbrink/affiliates-spark
```

On Laravel 5.5+, the `KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider` service provider and `KeithBrink\AffiliatesSpark\AffiliatesSparkFacade` facade will be automatically discovered so it will not need to be added to your config. On previous versions (untested), you will need to add those manually to your `config/app.php`.

## Configuration

///
To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish keithbrink/affiliates-spark
```

The vendor assets included in the package are:
- Views: /resources/views/vendor/affiliates-spark
///

1. In your User model, add the Affiliate trait:

```
use KeithBrink\KeithBrink\AffiliatesSpark\Traits\Affiliate as AffiliateTrait;

class User extends SparkUser {
    use AffiliateTrait;
    ...
}
```

2. Add a link for affiliates in the menu dropdown. Edit your `\resources\views\vendor\spark\nav\user.blade.php`, and under the Developer menu item (line 65), add the following code:

```
@if (Auth::user()->isAffiliate())
    @include('affiliates-spark::nav.affiliate-menu-item')
@endif
```

3. Add a link for managing affiliates in the Kiosk menu. Edit your `\resources\views\vendor\spark\kiosk.blade.php`, and under the Metrics Link item (line 30), add the following code:

```
<!-- Affiliates Link -->
@include('affiliates-spark::nav.affiliate-menu-item-kiosk')
```

## Usage

TODO

## License

SegmentSpark is licensed under [The MIT License (MIT)](LICENSE).