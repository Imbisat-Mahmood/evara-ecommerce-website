<?php
require_once 'config/db.php';

echo "<h3>Orders Table Structure:</h3>";
$result = mysqli_query($conn, "DESCRIBE orders");
echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach($row as $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<h3>Sample Orders Data:</h3>";
$result = mysqli_query($conn, "SELECT * FROM orders LIMIT 3");
echo "<pre>";
while($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}
echo "</pre>";
?>