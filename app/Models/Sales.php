<?php

/**
 * Sales model.
 *
 * @package     App\Models\Sales
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';

    protected $attributes = [
        'sales_agent_id' => '',
        'customer_id' => '',
        'product_id' => '',
        'price' => ''
    ];
}
