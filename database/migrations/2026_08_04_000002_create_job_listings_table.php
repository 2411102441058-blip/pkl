<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('nama_usaha');
            $table->string('posisi');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->text('syarat')->nullable();
            $table->string('lokasi');
            $table->string('tipe_pekerjaan')->default('Full Time');
            $table->string('gaji')->nullable();
            $table->string('nomor_wa');
            $table->boolean('is_premium')->default(false);
            $table->enum('status', ['pending', 'aktif', 'ditolak', 'kadaluarsa'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
