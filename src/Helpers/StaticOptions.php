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
        if (class_exists(Spark::class)) {
            return Spark::userModel();
        } else {
            return User::class;
        }
    }

    public static function user()
    {
        if (class_exists(Spark::class)) {
            return Spark::user();
        } else {
            return new User;
        }
    }

    public static function teamModel()
    {
        if (class_exists(Spark::class)) {
            return Spark::teamModel();
        } else {
            return Team::class;
        }
    }

    public static function invoiceModel()
    {
        if (class_exists(Spark::class)) {
            return new SparkLocalInvoice;
        } else {
            return new LocalInvoice;
        }
    }

    public static function allMonthlyPlans()
    {
        if (class_exists(Spark::class)) {
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
        if (class_exists(Spark::class)) {
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
        if (class_exists(Spark::class)) {
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
