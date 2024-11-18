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
        Schema::create('tabel', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->timestamps();
        });
        Schema::create('kolom', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tabel');
            $table->string('nama', 100);
            $table->integer('urutan');
            $table->timestamps();
        });
        Schema::create('baris', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tabel');
            $table->integer('urutan');
            $table->timestamps();
        });
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kolom');
            $table->integer('id_baris');
            $table->text('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel');
        Schema::dropIfExists('kolom');
        Schema::dropIfExists('baris');
        Schema::dropIfExists('data');
    }
};
