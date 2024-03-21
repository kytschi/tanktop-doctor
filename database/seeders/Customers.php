<?php

/**
 * Customers seeder.
 *
 * @package     Database\Seeders\Customers
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace Database\Seeders;

use App\Models\Customers as Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Customers extends Seeder
{
    public $first_names = [
        'Michael',
        'Kevin',
        'John',
        'Jane',
        'Harry',
        'Kate',
        'Laura',
        'Paul',
        'Mark',
        'Claire',
        'Brian',
        'Nick',
        'Aidan',
        'Oliver',
        'George',
        'Noah',
        'Arthur',
        'Leo',
        'Jack',
        'Charlie',
        'Oscar',
        'Jacob',
        'Henry',
        'Thomas',
        'Freddie',
        'Alfie',
        'Theo',
        'William',
        'Theodore',
        'Archie',
        'Joshua',
        'Alexander',
        'James',
        'Isaac',
        'Edward',
        'Lucas',
        'Tommy',
        'Finley',
        'Max',
        'Logan',
        'Ethan',
    ];

    public $last_names = [
        'Smith',
        'Clark',
        'Rubadue',
        'Corbyn',
        'Roberts',
        'Wilson',
        'Buttigieg',
        'Williams',
        'Jones',
        'Cook',
        'Geach',
        'Wrigley',
        'Nurse',
        'Poole',
        'Manley',
        'Ellis',
        'Shenton',
        'Holdsworth',
        'Bogie',
        'Lawson',
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($iLoop = 0; $iLoop < 100; $iLoop++) {
            $customer = new Model();
            $customer->name =
                $this->first_names[rand(0, count($this->first_names) - 1)] .
                " " .
                $this->last_names[rand(0, count($this->last_names) - 1)];

            $customer->email =
                str_replace(" ", ".", strtolower($customer->name)) .
                time() .
                '@kytschi.com';

            $customer->telephone = rand(1111111111, 9999999999);

            $customer->save();
        }
    }
}
