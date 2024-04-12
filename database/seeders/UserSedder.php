<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Juan',
            'lastname' => 'Perez',
            'address' => 'Calle 123',
            'phone' => 4154521,
            'cellPhone' => 63298521,
            'active' => true,
            'email' => 'ppp44@gmail.com',
            'password' => Hash::make('123456789'),
        ])->assignRole('admin');

        $admins = User::factory()->count(1)->admin()->create();
        $recepcionistas = User::factory()->count(2)->recepcionista()->create();
        $sastres = User::factory()->count(3)->sastre()->create();
        $clientes = User::factory()->count(5)->cliente()->create();
    }
}
