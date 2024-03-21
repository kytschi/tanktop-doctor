<?php

/**
 * Sales seeder.
 *
 * @package     Database\Seeders\Sales
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace Database\Seeders;

use App\Models\Sales as Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Sales extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($iLoop = 0; $iLoop < 10; $iLoop++) {
            //I get this is seeding into the future but its just dummy data.
            $date = rand(date('Y', strtotime("-3 year", time())), date('Y')) . '-' .
                    sprintf("%02d", rand(1, 12)) . '-' .
                    sprintf("%02d", rand(1, 28));

            for ($iLoop2 = 0; $iLoop2 < 100; $iLoop2++) {
                $product = DB::table('products')
                    ->inRandomOrder()
                    ->first();

                $agent = DB::table('sales_agents')
                    ->inRandomOrder()
                    ->first();

                $customer = DB::table('customers')
                    ->inRandomOrder()
                    ->first();

                Model::create([
                    'sales_agent_id' => $agent->id,
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                    'price' => ($product->price + (rand(-200, 200))),
                    'created_at' => $date
                ]);
            }
        }
    }
}
