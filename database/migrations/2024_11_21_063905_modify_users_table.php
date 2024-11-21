<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('remember_token');
            $table->renameColumn('name', 'nama');
            $table->string('level', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->timestamp('remember_token');
            $table->renameColumn('nama', 'name');
            $table->dropColumn('level');
        });
    }
};
