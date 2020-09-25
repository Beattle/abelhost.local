<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\{Department, User};
use Illuminate\{Database\Seeder, Support\Facades\DB, Support\Facades\Hash};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(15)->create();
        Department::factory(15)->create();

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.loc',
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
