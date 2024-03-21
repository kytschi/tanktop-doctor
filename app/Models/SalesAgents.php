<?php

/**
 * Sales Agents model.
 *
 * @package     App\Models\SalesAgents
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SalesAgents extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    protected $table = 'sales_agents';

    protected $attributes = [
        'name' => ''
    ];
}
