<?php

/**
 * Tanktop Doctor - some sales report app I guess :-P
 *
 * @package     App\Http\Controllers\Controller
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

use App\Http\Controllers\Controller;

$date = null;
if (!empty($_GET['date'])) {
    //I'm just looking for a valid date
    $date = strtotime($_GET['date']);
    if (!$date) {
        $date = null;
    } else {
        $date = $_GET['date'];
    }
}
$agents = Controller::getAgentsData($date);
$products = Controller::getProductsData($date);
$customers = Controller::getCustomersData($date);
$dates = Controller::getDatesData();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tanktop Doctor</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/css/app.css" rel="stylesheet" />
        <script src="/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="mt-5">
        <div class="container mx-auto">
            <form class="row mb-5" method="GET">
                <div class="col">
                    <div class="form-group">
                        <label>Filter by date</label>
                        <select name="date" class="form-control">
                            <option value="" <?= !$date ? ' selected' : ''; ?>>
                                <?= date("d/m/Y"); ?> (today)
                            </option>
                            <?php
                            if (count($dates)) {
                                foreach ($dates as $item) {
                                    //Skip today for now.
                                    if (date("Y-m-d", strtotime($item->created_at)) == date("Y-m-d")) {
                                        continue;
                                    }
                                    ?>
                                    <option value="<?= date("Y-m-d", strtotime($item->created_at)); ?>"
                                    <?= $date == date("Y-m-d", strtotime($item->created_at)) ? ' selected' : ''; ?>>
                                        <?= date("d/m/Y", strtotime($item->created_at)); ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col pt-4">
                    <?php
                    if ($date) {
                        ?>
                        <a href="/" class="btn btn-warning me-2">Clear</a>
                        <?php
                    }
                    ?>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
            <ul class="nav nav-tabs" id="tabs" role="tablist">
                <li class="nav-item">
                    <span class="nav-link active" id="tab-agents-tab" data-bs-toggle="tab" data-bs-target="#tab-agents" type="button" role="tab">Agents</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link" id="tab-products-tab" data-bs-toggle="tab" data-bs-target="#tab-products" type="button" role="tab">Products</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-customers" type="button" role="tab">Customers</span>
                </li>
            </ul>
            <div class="tab-content" id="tabs-tabContent">
                <div class="tab-pane fade show active" id="tab-agents" role="tabpanel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="60">&nbsp;</th>
                                <th>Agent</th>
                                <th>No. of sales</th>
                                <th>Cost total</th>
                                <th>Sale total</th>
                                <th>Profit/Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($agents)) {
                            foreach ($agents as $item) {
                                ?>
                                <tr>
                                    <td>
                                        <img width="100%" src="/imgs/<?= Controller::toImage($item->profit); ?>.png"/>
                                    </td>
                                    <td><?= $item->agent; ?></td>
                                    <td><?= $item->num_of_sales; ?></td>
                                    <td><?= Controller::toCurrency($item->actual_total); ?></td>
                                    <td><?= Controller::toCurrency($item->sold_total); ?></td>
                                    <td>
                                        <span class="badge rounded-pill text-bg-<?= ($item->profit <= 0) ? 'danger' : 'success'; ?>">
                                            <?= Controller::toCurrency($item->profit); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">No results</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab-products" role="tabpanel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>No. of sales</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($products)) {
                            foreach ($products as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->product; ?></td>
                                    <td><?= $item->num_of_sales; ?></td>
                                    <td><?= Controller::toCurrency($item->total); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3">No results</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab-customers" role="tabpanel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Customer<br/>
                                    <small>Email</small>
                                </th>
                                <th>No. of sales</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($customers)) {
                            foreach ($customers as $item) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $item->customer; ?><br/>
                                        <small><?= $item->email; ?></small>
                                    </td>
                                    <td><?= $item->num_of_sales; ?></td>
                                    <td><?= Controller::toCurrency($item->total); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3">No results</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </body>
</html>
