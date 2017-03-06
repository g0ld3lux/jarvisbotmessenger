<?php

use Illuminate\Database\Seeder;

class InitialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Permission::create(['permission' => 'master', 'description' => 'Master permission.']);
        App\Models\Permission::create(['permission' => 'access.admin', 'description' => 'Access admin panel.']);

        $user = App\Models\User::create([
              'name' => 'Uriah Galang',
              'email' => 'super.elite.vip@gmail.com',
              'verified' => true,
              'activated' => true
        ]);

        $user->permissions()->attach([1,2]);
    }
}