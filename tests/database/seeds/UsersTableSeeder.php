<?php

namespace AffiliatesSpark\Tests\Database\Seeds;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Test Account',
            'email' => 'keith@jasaratech.com',
            'email_verified_at' => now(),
            'password' => bcrypt('test'), // secret
            'remember_token' => str_random(10),
        ]);

        for ($i = 1; $i < 4; ++$i) {
            \DB::table('users')->insert([
                'name' => 'Test Account '.$i,
                'email' => str_random(10).'@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test'), // secret
                'remember_token' => str_random(10),
            ]);
        }
    }
}
