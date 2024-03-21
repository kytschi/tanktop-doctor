<?php

/**
 * Controller - I control the WORLD!
 *
 * @package     App\Http\Controllers\Controller
 * @author      Mike Welsh <hello@kytschi.com>
 * @link        https://kytschi.com
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    public static function getAgentsData($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        /*
         * I'm doing this purely for the speed.
         *
         * I said more speed dammit!
         * I can't do it Capt'n, she'll break apart....
         *
         * Since its SQLite can't really do this but if its repetitive data for
         * reports I'd look at a stored procedure in DB.
         */

        return DB::select(
            "SELECT
                a.name AS agent,
                COUNT(sales.id) AS num_of_sales,
                SUM(sales.price) AS sold_total,
                SUM(p.price) AS actual_total,
                SUM(sales.price) - SUM(p.price) AS profit
            FROM sales 
            JOIN sales_agents a ON a.id=sales.sales_agent_id
            JOIN products p ON p.id=sales.product_id 
            WHERE STRFTIME('%Y-%m-%d', sales.created_at) = :d
            GROUP BY sales_agent_id
            ORDER BY profit DESC, sold_total DESC, num_of_sales DESC",
            [
                'd' => $date
            ]
        );
    }

    public static function getCustomersData($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        return DB::select(
            "SELECT
                a.name AS customer,
                a.email,
                COUNT(sales.id) AS num_of_sales,
                SUM(sales.price) AS total
            FROM sales 
            JOIN customers a ON a.id=sales.customer_id
            WHERE STRFTIME('%Y-%m-%d', sales.created_at) = :d
            GROUP BY customer_id
            ORDER BY total DESC, num_of_sales DESC",
            [
                'd' => $date
            ]
        );
    }

    public static function getDatesData()
    {
        return DB::select(
            "SELECT
                created_at,
                COUNT(created_at) AS total
            FROM sales 
            GROUP BY STRFTIME('%Y-%m-%d', created_at)
            ORDER BY created_at DESC"
        );
    }

    public static function getProductsData($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        return DB::select(
            "SELECT
                a.name AS product,
                COUNT(sales.id) AS num_of_sales,
                SUM(sales.price) AS total
            FROM sales 
            JOIN products a ON a.id=sales.product_id
            WHERE STRFTIME('%Y-%m-%d', sales.created_at) = :d
            GROUP BY product_id
            ORDER BY total DESC, num_of_sales DESC",
            [
                'd' => $date
            ]
        );
    }

    public static function toImage($profit)
    {
        if ($profit <= -20) {
            return 1;
        } elseif ($profit <= -10) {
            return 2;
        } elseif ($profit <= 0) {
            return 3;
        } elseif ($profit <= 10) {
            return 4;
        } elseif ($profit <= 20) {
            return 5;
        } elseif ($profit <= 30) {
            return 6;
        } elseif ($profit <= 40) {
            return 7;
        } elseif ($profit <= 50) {
            return 8;
        } elseif ($profit <= 60) {
            return 9;
        } else {
            return 10;
        }
    }

    public static function toCurrency($number, $locale = 'en_GB')
    {
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency(
            floatval($number),
            $formatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE)
        );
    }
}
