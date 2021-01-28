<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                'name'       => 'Не известен',
                'email'      => 'unknown@user.mail',
                'password'   => bcrypt('54321'),
                'created_at' => now(),
            ],
            [
                'name'       => 'Артем',
                'email'      => 'ak74am@gmail.com',
                'password'   => bcrypt('12345'),
                'created_at' => now(),
            ],
        ];

        \Illuminate\Support\Facades\DB::table('users')->insert($data);
    }
}
