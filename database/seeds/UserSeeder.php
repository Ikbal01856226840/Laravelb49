<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'name' => 'Nipun',
            'email' => 'nipunsarker56@gmail.com',
            'password' => Hash::make('12345678'),
            'access_level' => 0,
            'status' => 1,
            'allow_sub_accounts' => 0,
            'account_valid_till' => NULL,
            'parent_id' => 0,
            'shop_name' => NULL,
            'address' => NULL,
            'phone' => NULL,
            'mobile' => NULL,
            'receipt_note' => NULL,
            'service_charge' => 0,
            'referenced_by' => NULL,
            'registration_date' => NULL,
            'reg_approval_status' => 0,
            'reg_approval_date' => NULL,
            'last_login_date' => NULL,
        ],
    );
    }
}
