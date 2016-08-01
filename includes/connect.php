<?php
$link = mysqli_connect("localhost", "lagertha", "sword", "lagertha");

if (!$link) {
    echo "Error: Unable to connect to Lagertha Database. Check to see that your database is running." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: Connection to Lagertha was successful." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);
?>
