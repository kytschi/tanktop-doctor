<?php

/**
 * Products model.
 *
 * @package     App\Models\Products
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';

    protected $attributes = [
        'name' => '',
        'price' => 0.00
    ];
}
