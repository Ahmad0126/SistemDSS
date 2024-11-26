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
            $table->integer('max_sumbu')->nullable();
            $table->integer('pie_kolom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel', function(Blueprint $table){
            $table->dropColumn('max_sumbu');
            $table->dropColumn('pie_kolom');
        });
    }
};
