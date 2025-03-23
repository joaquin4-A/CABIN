<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "cabinbyroyale";

    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
        echo "Failed to connect to DB" .$conn->connect_error;
    }
?>
