<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pemilik');
            $table->string('nama_usaha');
            $table->string('no_hp');
            $table->string('alamat_usaha')->nullable();
            $table->string('kategori_usaha')->nullable();
            $table->text('deskripsi_usaha')->nullable();
            $table->string('medsos_instagram')->nullable();
            $table->string('medsos_tiktok')->nullable();
            $table->string('medsos_facebook')->nullable();
            $table->string('website')->nullable();
            // Upload foto dokumen
            $table->string('foto_ktp')->nullable();
            $table->string('foto_sim')->nullable();
            $table->boolean('profil_lengkap')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
