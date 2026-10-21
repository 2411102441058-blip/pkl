<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('is_premium');
            $table->unsignedBigInteger('views_count')->default(0)->after('expires_at');
            $table->unsignedBigInteger('clicks_count')->default(0)->after('views_count');
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'views_count', 'clicks_count']);
        });
    }
};
