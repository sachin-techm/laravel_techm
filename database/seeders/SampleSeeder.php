<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->importAdmins();
        $this->importUsers();
    }

    private function importAdmins() {

        Admin::truncate();

        $data = [
            ['name'=>'Super Admin', 'email'=>'pk836746@gmail.com', 'password' => \Hash::make('123456'), 'status' => 1, 'role_id' => 0]
        ];

        foreach ($data as $key => $value) {
            
            Admin::create($value);

        }

    }

    private function importUsers() {

        User::truncate();

        $data = [
            ['name'=>'Test User', 'email'=>'testuser1@gmail.com', 'password' => \Hash::make('123456'), 'status' => 1, 'role_id' => 0]
        ];

        foreach ($data as $key => $value) {
            
            User::create($value);

        }

    }
}
