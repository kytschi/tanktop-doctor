<?php

/**
 * Database seeder.
 *
 * @package     Database\Seeders\DatabaseSeeder
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //Customers::class,
            //Products::class,
            //SalesAgents::class,
            Sales::class
        ]);
    }
}
