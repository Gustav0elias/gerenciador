<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UpdateGuardNameInRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Atualizar o guard_name de todos os roles para 'api'
        Role::where('guard_name', 'sanctum')->update(['guard_name' => 'api']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverter a alteração (se necessário), alterando para 'sanctum' novamente
        Role::where('guard_name', 'api')->update(['guard_name' => 'sanctum']);
    }
}
