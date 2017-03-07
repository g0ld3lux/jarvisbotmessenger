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

        $user1 = App\Models\User::create([
              'name' => 'Uriah Galang',
              'email' => 'super.elite.vip@gmail.com',
              'verified' => true,
              'activated' => true
        ]);

        $user1->permissions()->attach([1,2]);

        $user2 = App\Models\User::create([
              'name' => 'Gabriel Machuret',
              'email' => 'Gmachuret@gmail.com ',
              'verified' => true,
              'activated' => true
        ]);

        $user2->permissions()->attach([1,2]);
    }
}
