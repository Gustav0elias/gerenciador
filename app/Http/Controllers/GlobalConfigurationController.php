<?php

namespace App\Http\Controllers;

use App\Models\GlobalConfiguration;
use Illuminate\Http\Request;

class GlobalConfigurationController extends Controller
{


    public function getConfiguration()
    {
        $config = GlobalConfiguration::first();
        return response()->json($config);
    }

    public function updateBackgroundColor(Request $request)
    {
        $request->validate([
            'background_color' => 'required|string|min:7|max:7',
        ]);

        $config = GlobalConfiguration::first();

        if (!$config) {
            $config = GlobalConfiguration::create(['background_color' => $request->background_color]);
        } else {
            $config->update(['background_color' => $request->background_color]);
        }

        return response()->json(['message' => 'Configuração atualizada com sucesso']);
    }
}
