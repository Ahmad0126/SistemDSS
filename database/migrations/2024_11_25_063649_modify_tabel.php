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
        Schema::table('tabel', function(Blueprint $table){
            $table->integer('mr');
            $table->integer('ml');
            $table->integer('mt');
            $table->integer('mb');
            $table->integer('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel', function(Blueprint $table){
            $table->dropColumn('mr');
            $table->dropColumn('ml');
            $table->dropColumn('mt');
            $table->dropColumn('mb');
            $table->dropColumn('id_user');
        });
    }
};
