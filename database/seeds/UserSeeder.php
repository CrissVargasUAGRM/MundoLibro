<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'name'=>'Cristhian Vargas Quiroz',
            'email'=>'zen.capacitaciones.laravel@gmail.com',
            'password'=>bcrypt('123laraveL.'),
        ]);

        factory(User::class, 4)->create();
    }
}
