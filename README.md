# Tanktop Doctor

## The brief
Create a Laravel MVC module for retrieving, calculating, and displaying statistics:

Let’s assume the following database structure:
Customers - id, name, email, telephone,
Products - id, name, price
SalesAgents - id, name
Sales - id, datetime, customer, product, price, sales_agent

Retrieve, calculate and display number of sales and total price per sales agent / product / customer for each day.
There can be thousands of rows in the sales table, so we want to cache any calculated data.
Don’t worry too much about styling the view - as long as all is readable, it’s fine.

## Adjustments

Replaced the `datetime` with the normal laravel timestamps `created_at` and `updated_at`.

On the sales table `_id` is amended to the `customer`, `product` and `sales_agent` to indicate its an id.

## Seeders

There are some seeders written to fill the DB up with dummy data. Feel free to mod the main seeder to run which ever you'd like. Default `sales` is on.