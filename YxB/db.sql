-- Active: 1768468455063@@127.0.0.1@5432@youxbuild
CREATE DATABASE youxbuild;
SELECT * from users;
SELECT * FROM vendor_profiles;
SELECT * FROM products;
SELECT * FROM orders;
SELECT * FROM order_items;


-- Show store name + vendor email for approved vendors only”
SELECT v.store_name ,u.email from vendor_profiles v JOIN users u ON u.id = v.vendor_id where v.status = 'approved';
-- “Show all products that are available and in stock (> 0)”

SELECT * FROM products where availability_status = 'in_stock' AND stock_quantity > 0;

-- “Show each order with: order_reference clientname total_amount status”*
SELECT u.full_name , o.order_reference , o.status , o.total_amount FROM users u JOIN orders o ON u.id = o.client_id;

-- Show each vendor store name with number of products they have”

SELECT v.store_name , v.vendor_id, COUNT(p.vendor_id) as total FROM vendor_profiles v JOIN products p ON v.vendor_id = p.vendor_id GROUP BY v.vendor_id;

-- “Show all orders made in 2025”

SELECT * FROM orders where EXTRACT(YEAR FROM ordered_At) = 2026;


--“Find the client who spent the most money (total of orders)”

SELECT u.full_name , SUM(o.total_amount) as total from users u JOIN orders o ON u.id = o.client_id GROUP BY u.full_name ORDER BY total DESC limit 1;  --  OFFSET N to jump rows  

-- “Find the product that was ordered the most (by quantity)” 

select p.id , o.quantity ,COUNT(o.product_id) as total from products p JOIN order_items o ON p.id = o.product_id GROUP BY p.id , o.quantity ORDER BY o.quantity DESC;

-- Show total revenue per month (only delivered orders)”

SELECT SUM(total_amount) as total FROM orders where status = 'delivered';
