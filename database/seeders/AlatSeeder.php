<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Alat;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => Str::uuid(),
                'nama' => 'Oscilloscope Digital',
                'deskripsi' => 'Oscilloscope digital 50MHz dengan 2 channel untuk analisis sinyal elektronik.',
                'stok' => 5,
                'isBroken' => false,
                'harga' => 7500000,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Multimeter Digital',
                'deskripsi' => 'Multimeter digital presisi tinggi untuk pengukuran tegangan, arus, dan resistansi.',
                'stok' => 10,
                'isBroken' => false,
                'harga' => 1200000,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Function Generator',
                'deskripsi' => 'Generator fungsi 30MHz untuk menghasilkan berbagai bentuk gelombang.',
                'stok' => 3,
                'isBroken' => false,
                'harga' => 5000000,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Power Supply DC',
                'deskripsi' => 'Power supply DC triple output untuk eksperimen elektronika.',
                'stok' => 4,
                'isBroken' => true,
                'harga' => 3500000,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Spektrum Analyzer',
                'deskripsi' => 'Spektrum analyzer untuk analisis frekuensi sinyal RF.',
                'stok' => 2,
                'isBroken' => false,
                'harga' => 15000000,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Digital Caliper',
                'deskripsi' => 'Jangka sorong digital presisi tinggi untuk pengukuran dimensi.',
                'stok' => 15,
                'isBroken' => false,
                'harga' => 350000,
            ],
        ];

        foreach ($data as $item) {
            Alat::create($item);
        }
    }
} 