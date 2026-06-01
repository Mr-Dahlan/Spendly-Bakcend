<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 2; // ← Ganti sesuai user_id kamu

        $categories = [
            // Income
            ['nama' => 'Gaji & Pendapatan',   'type' => 'income',  'icon' => '💰'],
            ['nama' => 'Freelance',            'type' => 'income',  'icon' => '💻'],
            ['nama' => 'Investasi',            'type' => 'income',  'icon' => '📈'],
            ['nama' => 'Bonus',                'type' => 'income',  'icon' => '🎁'],
            ['nama' => 'Jual Barang',          'type' => 'income',  'icon' => '🛍️'],

            // Expense
            ['nama' => 'Makan & Minum',        'type' => 'expense', 'icon' => '🍔'],
            ['nama' => 'Transportasi',         'type' => 'expense', 'icon' => '🚗'],
            ['nama' => 'Belanja Bulanan',      'type' => 'expense', 'icon' => '🛒'],
            ['nama' => 'Tagihan & Utilitas',   'type' => 'expense', 'icon' => '💡'],
            ['nama' => 'Kesehatan',            'type' => 'expense', 'icon' => '🏥'],
            ['nama' => 'Hiburan',              'type' => 'expense', 'icon' => '🎬'],
            ['nama' => 'Pendidikan',           'type' => 'expense', 'icon' => '📚'],
            ['nama' => 'Pakaian',              'type' => 'expense', 'icon' => '👕'],
            ['nama' => 'Olahraga',             'type' => 'expense', 'icon' => '🏃'],
            ['nama' => 'Traveling',            'type' => 'expense', 'icon' => '✈️'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'user_id' => $userId,
                'nama'    => $cat['nama'],
                'type'    => $cat['type'],
                'icon'    => $cat['icon'],
            ]);
        }

        $this->command->info('CategorySeeder berhasil! 15 kategori dibuat.');
    }
}
