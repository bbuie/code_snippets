<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesAndPermissionsTables extends Migration
{
    public function up()
    {
        Schema::create('permissions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('permission_role', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::create('account_user_permission', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('account_user_id')->unsigned();
            $table->foreign('account_user_id')->references('id')->on('account_user')->onDelete('cascade');
        });
        Schema::create('account_user_role', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->integer('account_user_id')->unsigned();
            $table->foreign('account_user_id')->references('id')->on('account_user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('account_user_permission');
        Schema::dropIfExists('account_user_role');
    }
}
