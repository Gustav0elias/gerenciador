<?php

namespace Database\Seeders;

use App\Models\GlobalConfiguration;
use Illuminate\Database\Seeder;

class GlobalConfigurationSeeder extends Seeder
{
    public function run()
    {
        GlobalConfiguration::create([
            'background_color' => '#FFFFFF',  // Cor de fundo padrão, por exemplo.
        ]);
    }
}
