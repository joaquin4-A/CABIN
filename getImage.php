<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT valid_id_image FROM user_register WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($image_data);
        $stmt->fetch();

        // Set the appropriate headers
        header("Content-Type: image/jpeg");

        // Output the image data
        echo $image_data;
    }
}
?>