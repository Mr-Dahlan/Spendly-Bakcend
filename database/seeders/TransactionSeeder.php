<?php
namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 2;

        $cat = Category::where('user_id', $userId)->get()->keyBy('nama');
        $id = fn($name) => $cat[$name]->category_id ?? 16;

        $transactions = [

            // ── Januari 2026 ──────────────────────────────────
            ['type' => 'income',  'amount' => 9000000,  'description' => 'Gaji Januari',           'date' => '2026-01-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'expense', 'amount' => 380000,   'description' => 'Belanja mingguan',        'date' => '2026-01-03', 'cat' => 'Belanja Bulanan'],
            ['type' => 'expense', 'amount' => 80000,    'description' => 'Bensin motor',            'date' => '2026-01-05', 'cat' => 'Transportasi'],
            ['type' => 'expense', 'amount' => 160000,   'description' => 'Makan malam keluarga',    'date' => '2026-01-07', 'cat' => 'Makan & Minum'],
            ['type' => 'income',  'amount' => 600000,   'description' => 'Freelance edit video',    'date' => '2026-01-10', 'cat' => 'Freelance'],
            ['type' => 'expense', 'amount' => 210000,   'description' => 'Tagihan listrik',         'date' => '2026-01-12', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'expense', 'amount' => 120000,   'description' => 'Nonton bioskop',          'date' => '2026-01-15', 'cat' => 'Hiburan'],
            ['type' => 'expense', 'amount' => 270000,   'description' => 'Beli baju kerja',         'date' => '2026-01-18', 'cat' => 'Pakaian'],
            ['type' => 'income',  'amount' => 250000,   'description' => 'Jual barang bekas',       'date' => '2026-01-20', 'cat' => 'Jual Barang'],
            ['type' => 'expense', 'amount' => 190000,   'description' => 'Tagihan internet',        'date' => '2026-01-22', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'expense', 'amount' => 95000,    'description' => 'Gym bulanan',             'date' => '2026-01-25', 'cat' => 'Olahraga'],
            ['type' => 'expense', 'amount' => 70000,    'description' => 'Kopi & snack kantor',     'date' => '2026-01-28', 'cat' => 'Makan & Minum'],

            // ── Februari 2026 ─────────────────────────────────
            ['type' => 'income',  'amount' => 9000000,  'description' => 'Gaji Februari',           'date' => '2026-02-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'expense', 'amount' => 420000,   'description' => 'Belanja bulanan',         'date' => '2026-02-02', 'cat' => 'Belanja Bulanan'],
            ['type' => 'income',  'amount' => 800000,   'description' => 'Freelance desain logo',   'date' => '2026-02-05', 'cat' => 'Freelance'],
            ['type' => 'expense', 'amount' => 90000,    'description' => 'Parkir & bensin',         'date' => '2026-02-07', 'cat' => 'Transportasi'],
            ['type' => 'expense', 'amount' => 280000,   'description' => 'Obat & vitamin',          'date' => '2026-02-10', 'cat' => 'Kesehatan'],
            ['type' => 'expense', 'amount' => 130000,   'description' => 'Makan siang tim',         'date' => '2026-02-12', 'cat' => 'Makan & Minum'],
            ['type' => 'income',  'amount' => 1200000,  'description' => 'Dividen saham',           'date' => '2026-02-14', 'cat' => 'Investasi'],
            ['type' => 'expense', 'amount' => 220000,   'description' => 'Buku programming',        'date' => '2026-02-17', 'cat' => 'Pendidikan'],
            ['type' => 'expense', 'amount' => 520000,   'description' => 'Servis motor',            'date' => '2026-02-20', 'cat' => 'Transportasi'],
            ['type' => 'expense', 'amount' => 79000,    'description' => 'Langganan Netflix',       'date' => '2026-02-23', 'cat' => 'Hiburan'],
            ['type' => 'expense', 'amount' => 360000,   'description' => 'Tagihan PDAM & listrik',  'date' => '2026-02-25', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'income',  'amount' => 450000,   'description' => 'Bonus proyek kecil',      'date' => '2026-02-28', 'cat' => 'Bonus'],

            // ── Maret 2026 ────────────────────────────────────
            ['type' => 'income',  'amount' => 9000000,  'description' => 'Gaji Maret',              'date' => '2026-03-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'expense', 'amount' => 460000,   'description' => 'Belanja bulanan',         'date' => '2026-03-03', 'cat' => 'Belanja Bulanan'],
            ['type' => 'expense', 'amount' => 210000,   'description' => 'Makan di restoran',       'date' => '2026-03-05', 'cat' => 'Makan & Minum'],
            ['type' => 'income',  'amount' => 1400000,  'description' => 'Freelance web dev',       'date' => '2026-03-07', 'cat' => 'Freelance'],
            ['type' => 'expense', 'amount' => 160000,   'description' => 'Tagihan listrik',         'date' => '2026-03-10', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'expense', 'amount' => 750000,   'description' => 'Tiket konser',            'date' => '2026-03-12', 'cat' => 'Hiburan'],
            ['type' => 'expense', 'amount' => 100000,   'description' => 'Bensin & tol',            'date' => '2026-03-14', 'cat' => 'Transportasi'],
            ['type' => 'income',  'amount' => 550000,   'description' => 'Jual laptop lama',        'date' => '2026-03-16', 'cat' => 'Jual Barang'],
            ['type' => 'expense', 'amount' => 260000,   'description' => 'Kursus online',           'date' => '2026-03-18', 'cat' => 'Pendidikan'],
            ['type' => 'expense', 'amount' => 190000,   'description' => 'Sepatu olahraga',         'date' => '2026-03-20', 'cat' => 'Olahraga'],
            ['type' => 'expense', 'amount' => 330000,   'description' => 'Grocery mingguan',        'date' => '2026-03-24', 'cat' => 'Belanja Bulanan'],
            ['type' => 'income',  'amount' => 480000,   'description' => 'Cashback investasi',      'date' => '2026-03-28', 'cat' => 'Investasi'],

            // ── April 2026 ────────────────────────────────────
            ['type' => 'income',  'amount' => 9000000,  'description' => 'Gaji April',              'date' => '2026-04-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'income',  'amount' => 1800000,  'description' => 'Bonus Q1',                'date' => '2026-04-01', 'cat' => 'Bonus'],
            ['type' => 'expense', 'amount' => 520000,   'description' => 'Belanja lebaran',         'date' => '2026-04-03', 'cat' => 'Belanja Bulanan'],
            ['type' => 'expense', 'amount' => 310000,   'description' => 'THR keluarga',            'date' => '2026-04-05', 'cat' => 'Makan & Minum'],
            ['type' => 'expense', 'amount' => 1600000,  'description' => 'Tiket mudik',             'date' => '2026-04-07', 'cat' => 'Traveling'],
            ['type' => 'expense', 'amount' => 580000,   'description' => 'Oleh-oleh lebaran',       'date' => '2026-04-10', 'cat' => 'Belanja Bulanan'],
            ['type' => 'income',  'amount' => 900000,   'description' => 'Freelance desain UI',     'date' => '2026-04-13', 'cat' => 'Freelance'],
            ['type' => 'expense', 'amount' => 210000,   'description' => 'Tagihan internet',        'date' => '2026-04-15', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'expense', 'amount' => 185000,   'description' => 'Makan malam',             'date' => '2026-04-18', 'cat' => 'Makan & Minum'],
            ['type' => 'expense', 'amount' => 95000,    'description' => 'Bensin motor',            'date' => '2026-04-21', 'cat' => 'Transportasi'],
            ['type' => 'income',  'amount' => 320000,   'description' => 'Jual baju bekas',         'date' => '2026-04-24', 'cat' => 'Jual Barang'],
            ['type' => 'expense', 'amount' => 460000,   'description' => 'Tagihan listrik & air',   'date' => '2026-04-27', 'cat' => 'Tagihan & Utilitas'],

            // ── Mei 2026 ──────────────────────────────────────
            ['type' => 'income',  'amount' => 9500000,  'description' => 'Gaji Mei (naik)',         'date' => '2026-05-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'expense', 'amount' => 440000,   'description' => 'Belanja bulanan',         'date' => '2026-05-02', 'cat' => 'Belanja Bulanan'],
            ['type' => 'expense', 'amount' => 260000,   'description' => 'Makan di mal',            'date' => '2026-05-04', 'cat' => 'Makan & Minum'],
            ['type' => 'income',  'amount' => 1700000,  'description' => 'Freelance mobile app',    'date' => '2026-05-06', 'cat' => 'Freelance'],
            ['type' => 'expense', 'amount' => 110000,   'description' => 'Grab & Gojek',            'date' => '2026-05-08', 'cat' => 'Transportasi'],
            ['type' => 'expense', 'amount' => 370000,   'description' => 'Konsultasi dokter',       'date' => '2026-05-10', 'cat' => 'Kesehatan'],
            ['type' => 'income',  'amount' => 650000,   'description' => 'Dividen reksa dana',      'date' => '2026-05-12', 'cat' => 'Investasi'],
            ['type' => 'expense', 'amount' => 600000,   'description' => 'Beli sepatu baru',        'date' => '2026-05-14', 'cat' => 'Pakaian'],
            ['type' => 'expense', 'amount' => 210000,   'description' => 'Tagihan listrik',         'date' => '2026-05-16', 'cat' => 'Tagihan & Utilitas'],
            ['type' => 'expense', 'amount' => 800000,   'description' => 'Weekend trip Bandung',    'date' => '2026-05-17', 'cat' => 'Traveling'],
            ['type' => 'expense', 'amount' => 89000,    'description' => 'Langganan Spotify',       'date' => '2026-05-19', 'cat' => 'Hiburan'],
            ['type' => 'expense', 'amount' => 310000,   'description' => 'Grocery mingguan',        'date' => '2026-05-21', 'cat' => 'Belanja Bulanan'],
            ['type' => 'income',  'amount' => 550000,   'description' => 'Bonus performa',          'date' => '2026-05-23', 'cat' => 'Bonus'],
            ['type' => 'expense', 'amount' => 130000,   'description' => 'Makan siang',             'date' => '2026-05-25', 'cat' => 'Makan & Minum'],
            ['type' => 'expense', 'amount' => 100000,   'description' => 'Bensin & parkir',         'date' => '2026-05-27', 'cat' => 'Transportasi'],
            ['type' => 'expense', 'amount' => 420000,   'description' => 'Kursus UI/UX online',     'date' => '2026-05-29', 'cat' => 'Pendidikan'],

            // ── Juni 2026 ─────────────────────────────────────
            ['type' => 'income',  'amount' => 9500000,  'description' => 'Gaji Juni',               'date' => '2026-06-01', 'cat' => 'Gaji & Pendapatan'],
            ['type' => 'expense', 'amount' => 450000,   'description' => 'Belanja bulanan',         'date' => '2026-06-01', 'cat' => 'Belanja Bulanan'],
            ['type' => 'expense', 'amount' => 190000,   'description' => 'Makan siang bersama',     'date' => '2026-06-01', 'cat' => 'Makan & Minum'],
        ];

        $count = 0;
        foreach ($transactions as $trx) {
            Transaction::create([
                'user_id'          => $userId,
                'category_id'      => $id($trx['cat']),
                'type'             => $trx['type'],
                'amount'           => $trx['amount'],
                'description'      => $trx['description'],
                'transaction_date' => $trx['date'],
            ]);
            $count++;
        }

        $this->command->info("TransactionSeeder2 berhasil! {$count} transaksi dibuat.");
    }
}