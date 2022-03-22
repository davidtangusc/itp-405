<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Admin
            $table->string('slug'); // admin
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            // $table->foregin('role_id')->references('id')->on('roles');
            $table->foreignId('role_id')->contrained();
        });

        $roles = [
            'user' => 'User',
            'admin' => 'Admin',
        ];

        foreach ($roles as $slug => $name) {
            DB::table('roles')->insert([
                'slug' => $slug,
                'name' => $name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('users', ['role_id']);
        Schema::dropIfExists('roles');
    }
}
