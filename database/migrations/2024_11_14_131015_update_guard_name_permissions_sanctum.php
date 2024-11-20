<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class UpdateGuardNamePermissionsSanctum extends Migration
{
    public function up()
    {
        // Atualize as permissões para usar 'api' como guard_name
        Permission::where('guard_name', 'sanctum')
            ->update(['guard_name' => 'api']);
    }

    public function down()
    {
        // Restaura o guard_name para 'web' se necessário
        Permission::where('guard_name', 'api')
            ->update(['guard_name' => 'sanctum']);
    }
}
