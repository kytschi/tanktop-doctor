# Tanktop Doctor

## Task 1 - Programming
Create a Laravel MVC module for retrieving, calculating, and displaying statistics:

Let’s assume the following database structure:
Customers - id, name, email, telephone,
Products - id, name, price
SalesAgents - id, name
Sales - id, datetime, customer, product, price, sales_agent

Retrieve, calculate and display number of sales and total price per sales agent / product / customer for each day.
There can be thousands of rows in the sales table, so we want to cache any calculated data.
Don’t worry too much about styling the view - as long as all is readable, it’s fine.

### Adjustments

Replaced the `datetime` with the normal laravel timestamps `created_at` and `updated_at`.

On the sales table `_id` is amended to the `customer`, `product` and `sales_agent` to indicate its an id.

### Seeders

There are some seeders written to fill the DB up with dummy data. Feel free to mod the main seeder to run which ever you'd like. Default `sales` is on.

### Caching

I hope I'm understanding the caching part, but you'd want to enable memcache or redis. A noSQL like redis is often a better choice for caching reports as you can just run the report, cache it for say an hr then update it after an hr. PHP just reads the cached version.

Something I'd do when it comes to massive datasets but you want quick pulls, create a "stats" table for example. The data would just contain a `sales_agent_id` their number of sales and their totals. Make use of a stored procedure to insert/update the data and use a trigger in SQL to execute the procedure on an insert/update into the `sales` table. Basically a sale has happened so update their stats for the stats page. Then just query as normal but the dataset is a lot more lightweight and less intensive. Basically get the DB to do the heavy lifting.

If a trigger isn't a good fit you could just write a CRON to populate the stats table or have whatever the page/endpoint is that is handling the sales stuff do the updates.

## Task 2 - Design

Design a data flow chart for the following:

There is a drop shipping e-shop where customers buy physical products. All payments are processed via 3rd party payment gateway. After successful payment, we need to generate invoices and email them to customers. Every successful order should send a request to our supplier’s system via API; they then ship the goods. We get shipping updates from the supplier (using webhook) and notify our customer via email.

Try to think about some edge cases/errors and how to handle those.

### Flow chart


                             ________________
                            (      START     )
                             ────────────────
                                    |
                                    |
                                    V
                            __________________
                           /                  /
                          /       SALE       /
                         /_________________ /
                                    |
                                    |
                                    V
                                    ^
                               /         \
                              /   TAKE    \
                             /             \
                             \   PAYMENT   /<--------------------------
                              \           /                           |
                               \         /                            |
                                    v                                 |   
                                    |                                 |
                                    |                                 ^
                                    V                                 |
                         _______________________             ___________________
                        |                       |           |                   |
                        |    PROCESS PAYMENT    |           |   DISPLAY ERROR   |
                        |_______________________|           |___________________|
                                    |                                 |     
                                    |                                 ^
                                    |                                 |
                                    V                        ___________________
                                    ^                       |                   |
                               /         \                  |     LOG ERROR     |
                              /           \                 |___________________|
                             /   SUCCESS?  \                          |               
                             \             /--->-------------->--------
                              \           /
                               \         /              
                                    v       
                                    |
                                    |   YES      
                                    V
                -------------------------------------
                |                                   |                        
                V                                   V                        
         ___________________               __________________                
        |                   |             |                  |               
        |      GENERATE     |             |      INFORM      |                  
        |      INVOICE      |             |     SUPPLIER     |---------<------           
        |___________________|             |__________________|               |  
                |                                   |                        |  NO
                |-------<--------                   |                        |
                V               |                   |                        ^  
         ___________________    |                   |                    /       \ 
        |                   |   |                   V                   /         \   YES 
        |      EMAIL        |   |                   |                  /    3RD    \--->----- 
        |     CUSTOMER      |   ^                   |                  \    TRY?   /        | 
        |___________________|   |                   |                   \         /         |
                |               |                   v                    \       /          |
                |               |                   |                        v              V
                |               |                   |                        |          ___________
                v               |                   |                        |         (    END    )
                |               |                   |                        ^          ───────────  
                |               |                   V                        |
                |               |                   ^                 _______________
                V               ^               /       \            |               |
             ________           |              /         \           |   LOG ERROR   |
            (   END   )         |             /           \          |_______________|
             ─────────          |            /     API     \   NO            |
                                |            \   CALL OK?  /--->--------------
                                |             \           /          
                                |              \         /
                                |               \       /
                                |                   v
                                |                   |
                                ^                   |
                                |                   V
                                |           ___________________
                                |          /                   /
                                |         /      WEBHOOK      /
                                |        /___________________/
                                |                   |
                                |                   |
                                ^                   V
                                |           _________________
                                |          |                 |
                                |          |   UPDATE ORDER  |
                                |          |_________________|
                                |                  |
                                |                  |
                                ------------<------- 

### Notes

I'd have some error handling on the invoice generation and emailing. I'd basically have error handling at each step to be honest. I'd log the error but I'll often kick a message to a dev chat/channel say in Slack to let me know something has gone wrong.