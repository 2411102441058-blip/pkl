<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use Illuminate\Console\Command;

class CheckExpiredJobs extends Command
{
    /**
     * Nama dan tanda tangan dari perintah konsol.
     *
     * @var string
     */
    protected $signature = 'loker:check-expired';

    /**
     * Deskripsi dari perintah konsol.
     *
     * @var string
     */
    protected $description = 'Mengecek umur loker yang telah aktif > 30 hari dan mengubah statusnya menjadi Kadaluarsa.';

    /**
     * Eksekusi perintah konsol FASE 4.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan loker kadaluarsa...');

        // Cari loker aktif yang expires_at <= skrg atau approved_at/created_at > 30 hari yang lalu
        $count = 0;
        
        $expiredListings = JobListing::where('status', 'aktif')
            ->where(function ($query) {
                $query->where('expires_at', '<=', now())
                      ->orWhere(function ($q) {
                          $q->whereNull('expires_at')
                            ->where('approved_at', '<=', now()->subDays(30));
                      });
            })
            ->get();

        foreach ($expiredListings as $job) {
            $job->update([
                'status' => 'kadaluarsa',
            ]);
            $count++;
            $this->line("Loker ID {$job->id} - '{$job->posisi}' di '{$job->nama_usaha}' diubah menjadi Kadaluarsa.");
        }

        $this->info("Pengecekan selesai. Total {$count} loker diubah statusnya menjadi Kadaluarsa.");

        return Command::SUCCESS;
    }
}
