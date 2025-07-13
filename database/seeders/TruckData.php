<?php

namespace Database\Seeders;

use App\Models\Truck;
use App\Models\TruckType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $types = [
            [
                'code' => 'ENGKEL',
                'name' => 'Engkel Box',
                'ton_capacity' => 2.5,
                'length' => 320,
                'width' => 170,
                'height' => 160,
            ],
            [
                'code' => 'CDD',
                'name' => 'Colt Diesel Double',
                'ton_capacity' => 4.0,
                'length' => 420,
                'width' => 180,
                'height' => 190,
            ],
            [
                'code' => 'FUSO',
                'name' => 'Fuso Box',
                'ton_capacity' => 8.0,
                'length' => 560,
                'width' => 210,
                'height' => 220,
            ],
            [
                'code' => 'TRONTON',
                'name' => 'Tronton Box',
                'ton_capacity' => 20.0,
                'length' => 780,
                'width' => 240,
                'height' => 240,
            ],
            [
                'code' => 'TRAILER',
                'name' => 'Trailer Container',
                'ton_capacity' => 30.0,
                'length' => 1200,
                'width' => 250,
                'height' => 250,
            ],
            [
                'code' => 'WINGBOX',
                'name' => 'Wingbox',
                'ton_capacity' => 24.0,
                'length' => 950,
                'width' => 240,
                'height' => 240,
            ],
            [
                'code' => 'PICKUP',
                'name' => 'Pickup',
                'ton_capacity' => 1.0,
                'length' => 250,
                'width' => 140,
                'height' => 130,
            ],
        ];

        foreach ($types as $type) {
            TruckType::create($type);
        }


        $brands = ['Hino', 'Isuzu', 'Mitsubishi', 'Toyota', 'Hyundai'];
        $models = ['Ranger', 'Canter', 'Elf', 'Dutro', 'Xcient'];

        for ($i = 1; $i <= 20; $i++) {
            $type = TruckType::inRandomOrder()->first();

            Truck::create([
                'brand' => $brands[array_rand($brands)],
                'model' => $models[array_rand($models)],
                'year' => rand(2018, 2023),
                'police_number' => 'B ' . rand(1000, 9999) .' '. chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)),
                'truck_type_id' => $type->id,
                'kir_document' => 'kir-documents/01JZWC5WHV784D58ZCCS66VEH3.jpg',
            ]);
        }
    }
}
