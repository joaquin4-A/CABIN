<?php
require_once "connect.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = intval($_POST['id']);
        $status = $_POST['status'];

        // Validate status
        $allowed_statuses = ['processed', 'rejected'];
        if (!in_array($status, $allowed_statuses)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid status'
            ]);
            exit;
        }

        // Update the reservation status
        $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            // You might want to send an email to the user here
            echo json_encode([
                'status' => 'success',
                'message' => 'Reservation has been ' . $status
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update reservation status'
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required parameters'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}

$conn->close();
?>