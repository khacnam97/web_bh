<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class CreateRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleAdmin = DB::select("SELECT * FROM `roles` WHERE name ='admin' ");
        if (!$roleAdmin) {
            Role::create(['name' => 'admin']);
        }
        $roleDis = DB::select("SELECT * FROM `roles` WHERE name ='distribution center' ");
        if (!$roleDis) {
            Role::create(['name' => 'distribution center']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
