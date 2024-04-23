<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Detail;

class DetailSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = Detail::factory()->count(10)->create();
    }
}
