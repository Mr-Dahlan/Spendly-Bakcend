<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user yang ada
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        foreach ($users as $user) {
            // 1. Notif belum dibaca
            Notification::create([
                'user_id' => $user->user_id,
                'title'   => 'Selamat Datang di Spendly! 🎉',
                'message' => 'Halo ' . $user->name . '! Mulai catat pengeluaran dan pemasukanmu sekarang.',
                'is_read' => false,
            ]);

            // 2. Notif belum dibaca
            Notification::create([
                'user_id' => $user->user_id,
                'title'   => 'Tips Mengelola Keuangan 💡',
                'message' => 'Catat setiap transaksi secara rutin agar laporan keuanganmu lebih akurat.',
                'is_read' => false,
            ]);

            // 3. Notif sudah dibaca
            Notification::create([
                'user_id' => $user->user_id,
                'title'   => 'Fitur Kategori Tersedia 📂',
                'message' => 'Kamu sekarang bisa mengatur kategori transaksi sesuai kebutuhanmu.',
                'is_read' => true,
            ]);

            // 4. Notif sudah dibaca
            Notification::create([
                'user_id' => $user->user_id,
                'title'   => 'Profil Berhasil Dibuat ✅',
                'message' => 'Akun kamu telah berhasil didaftarkan. Selamat menggunakan Spendly!',
                'is_read' => true,
            ]);
        }

        $this->command->info('NotificationSeeder berhasil! ' . ($users->count() * 4) . ' notifikasi dibuat.');
    }
}