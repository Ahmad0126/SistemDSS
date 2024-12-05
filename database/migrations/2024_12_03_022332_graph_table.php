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
        Schema::create('user_tabel', function(Blueprint $table){
            $table->id();
            $table->integer('id_user');
            $table->string('nama', 200);
            $table->string('nama_asli');
            $table->timestamps();
        });
        Schema::create('user_grafik', function(Blueprint $table){
            $table->id();
            $table->integer('id_user');
            $table->string('judul', 200);
            $table->string('tipe', 20);
            $table->text('query')->nullable();
            $table->timestamps();
        });
        Schema::table('tabel', function(Blueprint $table){
            $table->dropColumn('nama_asli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tabel');
        Schema::dropIfExists('user_grafik');
        Schema::table('tabel', function(Blueprint $table){
            $table->string('nama_asli')->nullable();
        });
    }
};
