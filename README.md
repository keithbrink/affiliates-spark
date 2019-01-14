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

1. In your User model, add the Affiliate trait:

```
use KeithBrink\KeithBrink\AffiliatesSpark\Traits\Affiliate as AffiliateTrait;

class User extends SparkUser {
    use AffiliateTrait;
    ...
}
```

2. In your SparkServiceProvider, add the following functions to handle adding affiliate IDs to the database:

```
Spark::createUsersWith('KeithBrink\AffiliatesSpark\Interactions\SaveAffiliateOnRegistration@createUser');
Spark::createTeamsWith('KeithBrink\AffiliatesSpark\Interactions\SaveAffiliateOnRegistration@createTeam');
```

3. Add a link for affiliates in the menu dropdown. Edit `\resources\views\vendor\spark\nav\user.blade.php`, and under the Developer menu item (line 65), add the following code:

```
@if (Auth::user()->isAffiliate())
    @include('affiliates-spark::nav.affiliate-menu-item')
@endif
```

4. Add a link for managing affiliates in the Kiosk menu. Edit your `\resources\views\vendor\spark\kiosk.blade.php`, and under the Metrics Link item (line 30), add the following code:

```
<!-- Affiliates Link -->
@include('affiliates-spark::nav.affiliate-menu-item-kiosk')
```

5. Publish the package javascript with the command: `php artisan vendor:publish --provider="KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider" --tag=javascript`. Then, in your `/resources/js/app.js`, require the package javascript: `require('./affiliates-spark/bootstrap');`.

Remember to compile the assets with `npm run dev`.

6. Publish the package views with the command: `php artisan vendor:publish --provider="KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider" --tag=views`. You should enter instructions for your affiliates in `/resources/views/vendor/affiliates-spark/affiliates/instructions.blade.php`.

7. On any page that you would like to credit affiliates for sending people to, add the script: `<script async="" src="/a-s/aff.js"></script>`

## Usage

TODO

## License

SegmentSpark is licensed under [The MIT License (MIT)](LICENSE).