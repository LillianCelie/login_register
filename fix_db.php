
<?php
require 'config.php';

// Add missing columns to inventory table
$columns_to_add = [
    'batch_number' => "ALTER TABLE inventory ADD COLUMN batch_number INT NOT NULL DEFAULT 1",
    'sku' => "ALTER TABLE inventory ADD COLUMN sku VARCHAR(50) NOT NULL DEFAULT ''",
    'size' => "ALTER TABLE inventory ADD COLUMN size VARCHAR(50) DEFAULT NULL",
    'image_path' => "ALTER TABLE inventory ADD COLUMN image_path VARCHAR(255) DEFAULT NULL"
];

foreach ($columns_to_add as $col_name => $alter_query) {
    // Check if column exists
    $check_result = mysqli_query($conn, "SHOW COLUMNS FROM inventory WHERE Field='$col_name'");
    
    if ($check_result && mysqli_num_rows($check_result) == 0) {
        // Column doesn't exist, add it
        if (mysqli_query($conn, $alter_query)) {
            echo "✓ Added column: $col_name<br>";
        } else {
            echo "✗ Error adding $col_name: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "✓ Column $col_name already exists<br>";
    }
}

echo "<br><strong>Done! All columns are now in place.</strong><br>";
echo "You can now <a href='inventory.php'>go back to Inventory</a>";

mysqli_close($conn);
?>
