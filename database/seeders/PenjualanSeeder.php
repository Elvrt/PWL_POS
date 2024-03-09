<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'Pembeli' => 'Nadia',
                'penjualan_kode' => 'P01',
                'penjualan_tanggal' => '2024-01-01 12:01:00',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli'=> 'Nofan',
                'penjualan_kode' => 'P02',
                'penjualan_tanggal' => '2024-01-02 12:05:00',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli'=> 'Demian',
                'penjualan_kode' => 'P03',
                'penjualan_tanggal' => '2024-01-02 13:04:00',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli'=> 'Aldi',
                'penjualan_kode' => 'P04',
                'penjualan_tanggal' => '2024-01-01 13:07:00',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli'=> 'Udin',
                'penjualan_kode' => 'P05',
                'penjualan_tanggal' => '2024-01-03 14:00:00',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli'=> 'Radit',
                'penjualan_kode' => 'P06',
                'penjualan_tanggal' => '2024-01-01 14:15:00',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli'=> 'Alifian',
                'penjualan_kode' => 'P07',
                'penjualan_tanggal' => '2024-01-03 14:30:00',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli'=> 'Dito',
                'penjualan_kode' => 'P08',
                'penjualan_tanggal' => '2024-01-02 15:00:00',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli'=> 'Zagar',
                'penjualan_kode' => 'P09',
                'penjualan_tanggal' => '2024-01-01 15:40:00',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli'=> 'Dika',
                'penjualan_kode' => 'P10',
                'penjualan_tanggal' => '2024-01-02 15:50:00',
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
