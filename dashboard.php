<?php
// Start the session
session_start();

// Check if the session is not empty
if (!empty($_SESSION)) {
    // Iterate through the session variables and echo their key-value pairs
    foreach ($_SESSION as $key => $value) {
        echo "Key: $key, Value: $value<br>";
    }
} else {
    echo "No session variables are set.";
}
?>
