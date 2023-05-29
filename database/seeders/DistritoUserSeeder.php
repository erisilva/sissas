<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistritoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\User::all() as $user) {
            foreach (\App\Models\Distrito::all() as $distrito) {
                # if random in 0..1 is 1 then atach
                if (rand(0, 1) == 1){
                    $user->distritos()->attach($distrito->id);
                }
            }            
        }
    }
}
