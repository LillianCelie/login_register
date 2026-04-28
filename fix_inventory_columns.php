<?php
require 'config.php';

echo "<h2>Fixing Inventory Table...</h2>";

// Check which columns exist
$result = mysqli_query($conn, "SHOW COLUMNS FROM inventory");
$existing_columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $existing_columns[] = $row['Field'];
}

echo "<p>Current columns: " . implode(", ", $existing_columns) . "</p>";

// Array of columns to add with their definitions
$columns_to_add = [
    'batch_number' => "ALTER TABLE inventory ADD COLUMN batch_number INT NOT NULL DEFAULT 1",
    'sku' => "ALTER TABLE inventory ADD COLUMN sku VARCHAR(50) NOT NULL DEFAULT ''",
    'size' => "ALTER TABLE inventory ADD COLUMN size VARCHAR(50) DEFAULT NULL",
    'image_path' => "ALTER TABLE inventory ADD COLUMN image_path VARCHAR(255) DEFAULT NULL"
];

// Add missing columns
foreach ($columns_to_add as $col_name => $alter_query) {
    if (!in_array($col_name, $existing_columns)) {
        echo "<p>Adding column: $col_name</p>";
        if (mysqli_query($conn, $alter_query)) {
            echo "<p style='color: green;'>✓ Column '$col_name' added successfully</p>";
        } else {
            echo "<p style='color: red;'>✗ Error adding column '$col_name': " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: blue;'>✓ Column '$col_name' already exists</p>";
    }
}

echo "<p><strong>Database fix complete!</strong></p>";
echo "<p><a href='inventory.php'>Go back to Inventory</a></p>";

mysqli_close($conn);
?>
