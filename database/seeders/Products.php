<?php

/**
 * Products seeder.
 *
 * @package     Database\Seeders\Products
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace Database\Seeders;

use App\Models\Products as Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            'Amiga 500' => 99.99,
            'Amiga 600' => 129.99,
            'Amiga 1000' => 209.99,
            'Amiga 1200' => 169.99,
            'Amiga 2000' => 309.99,
            'Amiga 3000' => 409.99,
            'Amiga 4000' => 506.99,
        ];

        foreach ($products as $name => $price) {
            $product = new Model();
            $product->name = $name;
            $product->price = $price;
            $product->save();
        }
    }
}
