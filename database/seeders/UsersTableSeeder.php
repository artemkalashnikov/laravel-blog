<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'          =>  'Alena',
                'email'         =>  'unknown@user.mail',
                'password'      =>  bcrypt('54321'),
                'is_admin'      =>  false,
                'created_at'    =>  now(),
            ],
            [
                'name'          =>  'Artem',
                'email'         =>  'ak74am@gmail.com',
                'password'      =>  bcrypt('12345'),
                'is_admin'      =>  true,
                'created_at'    =>  now(),
            ],
        ];

        \Illuminate\Support\Facades\DB::table('users')->insert($data);
    }
}
