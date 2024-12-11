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
        Schema::dropIfExists('data');
        Schema::dropIfExists('baris');
        Schema::dropIfExists('kolom');
        Schema::dropIfExists('tabel');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('tabel', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('tipe', 10);
            $table->string('orientasi', 10);
            $table->integer('mr');
            $table->integer('ml');
            $table->integer('mt');
            $table->integer('mb');
            $table->integer('id_user');
            $table->integer('max_sumbu')->nullable();
            $table->integer('pie_kolom')->nullable();
            $table->timestamps();
        });
        Schema::create('kolom', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tabel');
            $table->string('nama', 100);
            $table->integer('urutan');
            $table->string('tipe_data', 20);
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
};
