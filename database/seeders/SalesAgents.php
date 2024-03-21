<?php

/**
 * Sales Agents seeder.
 *
 * @package     Database\Seeders\SalesAgents
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace Database\Seeders;

use App\Models\SalesAgents as Model;
use Database\Seeders\Customers;

class SalesAgents extends Customers
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($iLoop = 0; $iLoop < 10; $iLoop++) {
            $agent = new Model();
            $agent->name =
                $this->first_names[rand(0, count($this->first_names) - 1)] .
                " " .
                $this->last_names[rand(0, count($this->last_names) - 1)];
            $agent->save();
        }
    }
}
