# AffiliatesSpark

An affiliates package for [Laravel Spark](https://spark.laravel.com/) that allows you to track referrals from affiliates and pay commission.

## Installation

Cashier 10+ / Laravel 6+ is supported in the 1.* releases. To use older versions, use one of the 0.* releases.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```
$ composer require keithbrink/affiliates-spark
```

## Configuration

1. In your User model, add the Affiliate trait:

```php
use KeithBrink\AffiliatesSpark\Traits\Affiliate as AffiliateTrait;

class User extends SparkUser {
    use AffiliateTrait;
    ...
}
```

2. In your SparkServiceProvider, add the following functions to handle adding affiliate IDs to the database:

```php
Spark::createUsersWith('KeithBrink\AffiliatesSpark\Interactions\SaveAffiliateOnRegistration@createUser');
Spark::createTeamsWith('KeithBrink\AffiliatesSpark\Interactions\SaveAffiliateOnRegistration@createTeam');
```

or, if you want to add extra data to your user registration, use the interaction directly:

```php
use KeithBrink\AffiliatesSpark\Interactions\SaveAffiliateOnRegistration;
...
Spark::createUsersWith(function ($request) {
    $extra_data = [
        ...
    ];

    $interaction = new SaveAffiliateOnRegistration;
    return $interaction->createUser($request, $extra_data);
});
```

3. Add a link for affiliates in the menu dropdown. Edit `\resources\views\vendor\spark\nav\user.blade.php`, and under the Developer menu item (line 65), add the following code:

```php
@if (Auth::user()->isAffiliate())
    @include('affiliates-spark::nav.affiliate-menu-item')
@endif
```

4. Add a link for managing affiliates in the Kiosk menu. Edit your `\resources\views\vendor\spark\kiosk.blade.php`, and under the Metrics Link item (line 30), add the following code:

```php
<!-- Affiliates Link -->
@include('affiliates-spark::nav.affiliate-menu-item-kiosk')
```

and in the same file under Tab Cards, add the following code:

```
<!-- Affiliates Tab -->
@include('affiliates-spark::nav.affiliate-tab-item-kiosk')
```

5. Publish the package javascript with the command: `php artisan vendor:publish --provider="KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider" --tag=javascript`. Then, in your `/resources/js/app.js`, require the package javascript: `require('./affiliates-spark/bootstrap');`.

Remember to compile the assets with `npm run dev`.

6. Publish the package views with the command: `php artisan vendor:publish --provider="KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider" --tag=views`. You should enter instructions for your affiliates in `/resources/views/vendor/affiliates-spark/affiliates/instructions.blade.php`.

### Optional Configuration

1. If you would like your customers to see the discount they are receiving from an affiliate on the subcription page, in your `resources/views/vendor/spark/settings/subscription/subscription-notice.blade.php` file, add `@include('affiliates-spark::subscription.affiliate-discount')` after the `@else` statement (line 9).

## Usage

1. On any page that you would like to credit affiliates for sending people to, add the script: `<script async="" src="/a-s/aff.js"></script>`. You can also add the script to a different subdomain of the same top-level domain by making the src URL absolute rather than relative.

## License

SegmentSpark is licensed under [The MIT License (MIT)](LICENSE).
