<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 1;

        if (($handle = fopen(database_path('property-data.csv'), "r")) !== false) {
            while (([$name, $price, $bedrooms, $bathrooms, $storeys, $garages] = fgetcsv($handle, 1000)) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                \App\Models\Property::create([
                    'name'      => $name,
                    'price'     => $price,
                    'bedrooms'  => $bedrooms,
                    'bathrooms' => $bathrooms,
                    'storeys'   => $storeys,
                    'garages'   => $garages
                ]);

                $row++;
            }

            fclose($handle);
        }
    }
}
