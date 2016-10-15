<?php

use Illuminate\Database\Seeder;

class DemoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create(['name' => 'demo', 'email' => 'demo@demo.com', 'password' => bcrypt('demo')]);

        $user->projects()->create([
            'title' => 'demo',
        ]);

        \DB::unprepared(file_get_contents(__DIR__.'/demo.sql'));
    }
}
