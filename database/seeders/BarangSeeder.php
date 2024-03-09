<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'KMJ',
                'barang_nama' => 'Kemeja',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 2,
                'barang_kode' => 'MSK',
                'barang_nama' => 'Maskara',
                'harga_beli' => 30000,
                'harga_jual' => 35000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3,
                'barang_kode' => 'KYB',
                'barang_nama' => 'Keyboard',
                'harga_beli' => 110000,
                'harga_jual' => 115000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 4,
                'barang_kode' => 'TFL',
                'barang_nama' => 'Teflon',
                'harga_beli' => 50000,
                'harga_jual' => 55000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 5,
                'barang_kode' => 'KBA',
                'barang_nama' => 'Kebab Ayam',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 1,
                'barang_kode' => 'JKT',
                'barang_nama' => 'Jaket',
                'harga_beli' => 40000,
                'harga_jual' => 45000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'LPS',
                'barang_nama' => 'Lipstick',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3,
                'barang_kode' => 'SEP',
                'barang_nama' => 'Speaker',
                'harga_beli' => 150000,
                'harga_jual' => 155000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 4,
                'barang_kode' => 'SPI',
                'barang_nama' => 'Sapu Ijuk',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'KPE',
                'barang_nama' => 'Keripik Tempe',
                'harga_beli' => 17000,
                'harga_jual' => 22000,
            ],

        ];
        DB::table('m_barang')->insert($data);
    }
}
