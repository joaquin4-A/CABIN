<?php
require_once "connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare SQL to fetch image BLOB
    $stmt = $conn->prepare("SELECT receipt_screenshot FROM reservation WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imageData);
        $stmt->fetch();

        // Set the proper content type
        header("Content-Type: image/jpeg");

        // Output the image data
        echo $imageData;
    }

    $stmt->close();
}
$conn->close();
?>