<?php
include 'connect.php';

// Rate definitions (note the lowercase keys to match select values)
$rates = [
    'day' => 6800,       // 9AM-5PM
    'night' => 7800,     // 8PM-6AM
    'weekdays' => 12000, // 21 HRS (9AM-6AM/8PM-5PM)
    'weekends' => 12800  // 21 HRS (9AM-6AM/8PM-5PM)
];

// Excess guest charge
$excess_guest_charge = 300;

function calculateTotalAmount($rate_type, $adult_guests, $child_guests, $rates, $excess_guest_charge) {
    // Normalize rate type to lowercase
    $rate_type = strtolower($rate_type);

    // Validate rate type
    if (!isset($rates[$rate_type])) {
        throw new Exception("Invalid rate type: " . $rate_type);
    }

    // Base rate
    $total_amount = $rates[$rate_type];

    // Check for excess guests (over 15 pax)
    $total_guests = $adult_guests + $child_guests;
    if ($total_guests > 15) {
        $total_amount += $excess_guest_charge;
    }

    if ($adult_guests > 15) {
        $excess_adult_charge = ($adult_guests - 15) * 300;
        $total_amount += $excess_adult_charge;
    }

    // Additional charge if kids > 4
    if ($child_guests > 4) {
        $total_amount += $excess_guest_charge;
    }

    return $total_amount;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $check_in = $_POST['check-in'];
        $check_out = $_POST['check-out'];
        $rate_type = $_POST['rates-select'];
        $adult_guests = intval($_POST['adult-guests']);
        $child_guests = intval($_POST['child-guests'] ?? 0);
        $special_requests = $_POST['special-request'] ?? null;

        // Calculate total amount
        $total_amount = calculateTotalAmount($rate_type, $adult_guests, $child_guests, $rates, $excess_guest_charge);

        // Validate receipt screenshot upload
        if (!isset($_FILES['file-upload-receipt']) || $_FILES['file-upload-receipt']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Please upload your receipt screenshot.');
        }

        $receipt_file = $_FILES['file-upload-receipt'];

        // Validate file size (limit to 16MB to match MEDIUMBLOB)
        if ($receipt_file['size'] > 16777215) {
            throw new Exception('File is too large. Maximum size is 16MB.');
        }

        // Validate file type using mime content
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $receipt_file['tmp_name']);
        finfo_close($finfo);

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($mime_type, $allowed_types)) {
            throw new Exception('Invalid file type. Please upload PNG, JPEG, or JPG files only.');
        }

        // Read the image file
        $image_data = file_get_contents($receipt_file['tmp_name']);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO reservation 
            (email, check_in, check_out, rate_type, adult_guest, child_guest, 
            receipt_screenshot, special_request, total_amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters - note the correct types:
        // s = string, i = integer, b = blob, d = double
        $stmt->bind_param(
            "ssssiissd",  // 9 parameters: string, string, string, string, int, int, string(blob), string, double
            $email,
            $check_in,
            $check_out,
            $rate_type,
            $adult_guests,
            $child_guests,
            $image_data,
            $special_requests,
            $total_amount
        );

        if ($stmt->execute()) {
            header("Location: reservation.php");
            exit;
        } else {
            return "Error: " . $stmt->error;
        }

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

// Close connection
$conn->close();
?>