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
        Schema::table('user_grafik', function(Blueprint $table){
            $table->string('orientasi', 10)->nullable();
            $table->integer('mr')->nullable();
            $table->integer('ml')->nullable();
            $table->integer('mt')->nullable();
            $table->integer('mb')->nullable();
            $table->integer('max_sumbu')->nullable();
            $table->integer('pie_kolom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_grafik', function(Blueprint $table){
            $table->dropColumn('orientasi');
            $table->dropColumn('mr');
            $table->dropColumn('ml');
            $table->dropColumn('mt');
            $table->dropColumn('mb');
            $table->dropColumn('max_sumbu');
            $table->dropColumn('pie_kolom');
        });
    }
};
