<?php
// Start the session with database config
session_start();
require_once '../../config/config.php';
$error = null;

// Create database tables
$sql = "
    INSERT INTO categories (category) VALUES
    ('Energy Consumption'),
    ('Food Consumption'),
    ('Travel'),
    ('Waste Management'),
    ('Water Consumption');

    INSERT INTO units (unit) VALUES
    ('Day'),
    ('Kilogram'),
    ('Kilometer'),
    ('Liter');

    INSERT INTO emissions (category_id, activity, unit_id, emission_per_unit, remarks) VALUES
    (1, 'Electric Fan', 1, 0.145, 'Based on average daily usage'),
    (1, 'Laptop or Desktop Computer', 1, 0.280, 'Based on average usage duration'),
    (1, 'Microwave Oven', 1, 0.271, 'Based on standard usage patterns'),
    (1, 'Oven Toaster', 1, 0.196, 'Based on daily usage'),
    (1, 'Printer', 1, 0.145, 'Based on normal printing usage'),
    (1, 'Smartphone', 1, 0.101, 'Based on typical charging use'),
    (1, 'Television', 1, 0.179, 'Based on standard viewing duration'),

    (2, 'Apple', 2, 0.4, 'Fresh apple'),
    (2, 'Banana', 2, 0.7, 'Fresh banana'),
    (2, 'Beef', 2, 60, 'Cooked beef'),
    (2, 'Beer', 2, 0.768, 'Brewed beer'),
    (2, 'Bread', 2, 1.215, 'Baked wheat bread'),
    (2, 'Cane Sugar', 2, 3, 'Refined cane sugar'),
    (2, 'Cheese', 2, 21, 'Processed dairy cheese'),
    (2, 'Chicken', 2, 6, 'Cooked chicken'),
    (2, 'Chocolate', 2, 19, 'Processed chocolate product'),
    (2, 'Citrus Fruits', 2, 0.3, 'Fresh citrus fruits (e.g., oranges, lemons)'),
    (2, 'Coffee', 2, 17, 'Brewed coffee'),
    (2, 'Eggs', 2, 4.5, 'Cooked eggs'),
    (2, 'Fish', 2, 5, 'Cooked fish'),
    (2, 'Leafy Vegetables', 2, 0.35, 'Fresh leafy vegetables (e.g., lettuce, spinach)'),
    (2, 'Milk', 2, 3, 'Pasteurized cow milk'),
    (2, 'Nuts', 2, 0.3, 'Raw or roasted nuts'),
    (2, 'Pork', 2, 7, 'Cooked pork'),
    (2, 'Prawns', 2, 12, 'Cooked prawns'),
    (2, 'Rice', 2, 4, 'Cooked white rice'),
    (2, 'Root Vegetables', 2, 0.4, 'Raw root vegetables (e.g., carrots, beets)'),
    (2, 'Soymilk', 2, 0.9, 'Processed soymilk'),
    (2, 'Tea', 2, 0.605, 'Brewed tea'),

    (3, 'Bus', 3, 0.097, 'Average for a diesel-powered city or local bus'),
    (3, 'Flight', 3, 0.150, 'Average for both short-haul and long-haul commercial flights'),
    (3, 'Jeepney', 3, 0.114, 'Based on a traditional gasoline-fueled jeepney'),
    (3, 'Motorcycle', 3, 0.114, 'Based on a standard two-wheel gasoline motorcycle'),
    (3, 'Plug-in Hybrid', 3, 0.068, 'Average for a plug-in hybrid electric vehicle'),
    (3, 'Private Vehicle', 3, 0.170, 'Average for a gasoline-powered passenger car'),
    (3, 'Train', 3, 0.035, 'Average for electric or diesel-powered passenger trains'),
    
    (4, 'Organic Waste: Composting', 2, 0.041, 'Net from composting process'),
    (4, 'Organic Waste: Landfilling', 2, 0.4, 'From disposal in landfill'),
    (4, 'Plastic Waste: Production & Incineration', 2, 3.0, 'From production and incineration'),
    (4, 'Plastic Waste: Recycling', 2, 0.45, 'From plastic recycling (PET)'),

    (5, 'Bottled Water', 4, 0.170, 'Per liter including production and transportation'),
    (5, 'Desalinated Water', 4, 0.002, 'Per liter based on average desalination energy use');  
";

if ($conn->multi_query($sql) === TRUE) {
    echo "Values inserted successfully";

    // Clear remaining results from multi_query
    do {
    } while ($conn->more_results() && $conn->next_result());

} else {
    echo "Error inserting values: " . $conn->error;
}

$conn->close();
?>