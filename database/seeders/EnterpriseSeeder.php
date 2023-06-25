<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder
 * before u run the project
 * to create the first role and user of enterprise level.
 */

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enterprise = Enterprise::query()->firstOrCreate(
            [
                'name'      => 'Test Enterprise',
                'contact'   => 'Testo',
                'email'     => 'testo@testenterprise.com',
                'api_key'     => Str::random(10),
            ]
        );

        $user = User::query()->create([
            'name'          => 'Testo',
            'email'         => 'testo@testenterprise.com',
            'password'      => bcrypt('test'),
            'enterprise_id' => $enterprise->id,
        ]);



        $role = Role::query()->create(
            [
                'name'          => 'Enterprise Admin',
                'guard_name'    => 'user',
                'user_level_id' => 2,
                'enterprise_id' => $enterprise->id,
            ]
        );

        $permissions = Permission::query()->where(['guard_name' => 'user'])->get();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
