<?php

/**
 * Customers model.
 *
 * @package     App\Models\Customers
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';

    protected $attributes = [
        'name' => '',
        'email' => '',
        'telephone' => ''
    ];
}
