<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'super_user'
            ],
            [
                'id' => 3,
                'name' => 'company'
            ],
            [
                'id' => 4,
                'name' => 'costumer'
            ],
        ];

            Role::query()->insert($roles);

    }
}
