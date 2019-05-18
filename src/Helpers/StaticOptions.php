<?php

namespace KeithBrink\AffiliatesSpark\Helpers;

use Laravel\Spark\Spark;
use Laravel\Spark\LocalInvoice as SparkLocalInvoice;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use KeithBrink\AffiliatesSpark\Traits\Affiliate;
use Laravel\Cashier\Billable;
use Laravel\Spark\Repositories\UserRepository;

class StaticOptions
{
    public static function userModel()
    {
        if (config('app.env') != 'testing') {
            return Spark::userModel();
        } else {
            return User::class;
        }
    }

    public static function user()
    {
        if (config('app.env') != 'testing') {
            return Spark::user();
        } else {
            return new User;
        }
    }

    public static function teamModel()
    {
        if (config('app.env') != 'testing') {
            return Spark::teamModel();
        } else {
            return Team::class;
        }
    }

    public static function invoiceModel()
    {
        if (config('app.env') != 'testing') {
            return new SparkLocalInvoice;
        } else {
            return new LocalInvoice;
        }
    }

    public static function allMonthlyPlans()
    {
        if (config('app.env') != 'testing') {
            return Spark::allMonthlyPlans();
        } else {
            return collect([(object)[
                'id' => 'standard',
                'price' => 50,
            ]]);
        }
    }

    public static function allYearlyPlans()
    {
        if (config('app.env') != 'testing') {
            return Spark::allYearlyPlans();
        } else {
            return collect([(object)[
                'id' => 'standard-yearly',
                'price' => 500,
            ]]);
        }
    }

    public static function createUser($data)
    {
        if (config('app.env') != 'testing') {
            return Spark::interact(UserRepository::class . '@create', [$data]);
        } else {
            return User::create($data);
        }
    }
}

class User extends Authenticatable
{
    use Affiliate, Billable;
    protected $guarded = ['id'];
}

class Team extends Eloquent
{
    //
}

class LocalInvoice extends Eloquent
{
    protected $table = 'invoices';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
