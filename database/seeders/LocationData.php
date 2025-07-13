<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['lat' => -6.125556, 'long' => 106.655833, 'place_name' => 'Tanjung Priok Port - Jakarta'],
            ['lat' => -7.336496, 'long' => 112.718963, 'place_name' => 'Pelabuhan Tanjung Perak - Surabaya'],
            ['lat' => -6.284361, 'long' => 106.869111, 'place_name' => 'Gudang Utama - Cakung'],
            ['lat' => -6.989604, 'long' => 110.422273, 'place_name' => 'Kawasan Industri Terboyo - Semarang'],
            ['lat' => -7.354664, 'long' => 108.262610, 'place_name' => 'Gudang Kargo - Tasikmalaya'],
            ['lat' => -6.248267, 'long' => 106.972722, 'place_name' => 'Terminal Petikemas - Pulogebang'],
            ['lat' => -6.980694, 'long' => 110.438125, 'place_name' => 'Gudang Komersil - Semarang Barat'],
            ['lat' => -7.274448, 'long' => 112.719087, 'place_name' => 'Depo Logistik - Surabaya Selatan'],
            ['lat' => -6.246884, 'long' => 106.816637, 'place_name' => 'SCM Warehouse - SCBD Jakarta'],
            ['lat' => -6.217622, 'long' => 106.844453, 'place_name' => 'Gudang Sentral - Kemayoran'],
            ['lat' => -6.907745, 'long' => 107.611618, 'place_name' => 'Kawasan Industri - Rancaekek Bandung'],
            ['lat' => -6.894280, 'long' => 107.589973, 'place_name' => 'PT Pos Logistik - Bandung'],
            ['lat' => -6.305389, 'long' => 106.886486, 'place_name' => 'MM2100 - Cibitung'],
            ['lat' => -6.254572, 'long' => 107.010790, 'place_name' => 'Greenland International Industrial Center - GIIC'],
            ['lat' => -6.224340, 'long' => 106.826110, 'place_name' => 'Gudang Kemang - Jakarta Selatan'],
            ['lat' => -5.147665, 'long' => 119.432732, 'place_name' => 'Pelabuhan Soekarno-Hatta - Makassar'],
            ['lat' => -3.988180, 'long' => 122.512201, 'place_name' => 'Pelabuhan Nusantara - Kendari'],
            ['lat' => -0.883116, 'long' => 119.870747, 'place_name' => 'Gudang Palu - Sulawesi Tengah'],
            ['lat' => 3.588898, 'long' => 98.673798, 'place_name' => 'Pelabuhan Belawan - Medan'],
            ['lat' => -6.210270, 'long' => 106.781857, 'place_name' => 'Warehouse Alam Sutera - Tangerang'],
            ['lat' => -6.248385, 'long' => 106.797843, 'place_name' => 'Gudang Logistik - BSD City'],
            ['lat' => -6.940844, 'long' => 107.594177, 'place_name' => 'Gudang Cimahi Utara'],
            ['lat' => -7.290293, 'long' => 112.727148, 'place_name' => 'Gudang Pergudangan Margomulyo - Surabaya'],
            ['lat' => -6.945821, 'long' => 107.581632, 'place_name' => 'Logistik Center - Padalarang'],
            ['lat' => -6.206566, 'long' => 106.830262, 'place_name' => 'Jakarta International Container Terminal (JICT)'],
        ];

        foreach ($locations as $i => $loc) {
            Location::create([
                'lat' => $loc['lat'],
                'long' => $loc['long'],
                'place_name' => $loc['place_name'],
                'contacts' => [
                    [
                        'name' => fake()->name,
                        'position' => fake()->jobTitle,
                        'phone' => '08' . rand(1000000000, 9999999999),
                    ]
                ],
            ]);
        }
    }
}
