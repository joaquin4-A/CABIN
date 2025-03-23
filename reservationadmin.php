<?php
require_once "connect.php";

// Fetch all reservations
$sql = "SELECT * FROM reservation ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../.Stylesheet/adminpanel.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../../../.image-cabin/favicon-16x16.png">
    <title>Admin Panel</title>
    <style>

        .main-content {
            padding: 10px;
            width: auto;
        }

        .main-content h2 {
            color: #43302e;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        /* Table styles */
        .reservation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .reservation-table th,
        .reservation-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .reservation-table th {
            background-color: #f4f4f4;
            text-transform: uppercase;
            color: #43302e;
        }

        .view-btn {
            padding: 5px 10px;
            background-color: #8B4513;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }

        .view-btn:hover {
            background-color:  #964b00;
        }

        .modal-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin: 2px;
            color: white;
        }

        .process-btn {
            background-color: #4CAF50;
        }

        .process-btn:hover {
            background-color: #45a049;
        }

        .reject-btn {
            background-color: #f44336;
        }

        .reject-btn:hover {
            background-color: #da190b;
        }

        .status-pending {
            color: #ff9800;
            font-weight: bold;
        }

        .status-processed {
            color: #4CAF50;
            font-weight: bold;
        }

        .status-rejected {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo">Admin Panel</div>
        <ul class="nav-links">
            <li><a href="adminpanel.php">Home</a></li>
            <li><a href="registeradmin.php">User Register</a></li>
            <li><a href="#">Reservation</a></li>
            <li><a href="calendareditor.php">Calendar Editor</a></li>
        </ul>
        <div class="logout">Log Out</div>
    </div>
    <div class="main-content">
        <h2>Reservations</h2>
        <table class="reservation-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Rate Type</th>
                <th>Adult Guests</th>
                <th>Child Guests</th>
                <th>Special Request</th>
                <th>Total Amount</th>
                <th>Receipt</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $status_class = 'status-' . strtolower($row['status'] ?? 'pending');
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_in']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($row['rate_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['adult_guest']); ?></td>
                        <td><?php echo htmlspecialchars($row['child_guest']); ?></td>
                        <td><?php echo htmlspecialchars($row['special_request']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                        <td>
                            <button class="action-btn view-btn" onclick="openModal(<?php echo $row['id']; ?>)">
                                View Receipt
                            </button>
                        </td>
                        <td class="<?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($row['status'] ?? 'Pending'); ?>
                        </td>
                        <td>
                            <?php if (($row['status'] ?? 'pending') == 'pending'): ?>
                                <button class="action-btn process-btn" onclick="updateStatus(<?php echo $row['id']; ?>, 'processed')">
                                    Process
                                </button>
                                <button class="action-btn reject-btn" onclick="updateStatus(<?php echo $row['id']; ?>, 'rejected')">
                                    Reject
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='12'>No reservations found</td></tr>";
            }
            mysqli_free_result($result);
            ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Modal -->
<div id="receiptModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="receiptImage" class="modal-image" src="" alt="Receipt Screenshot">
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById('receiptModal');
        const modalImg = document.getElementById('receiptImage');
        modal.style.display = "block";
        modalImg.src = `serve-image.php?id=${id}`;
    }

    function closeModal() {
        const modal = document.getElementById('receiptModal');
        modal.style.display = "none";
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('receiptModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    function updateStatus(id, status) {
        if (confirm(`Are you sure you want to ${status} this reservation?`)) {
            fetch('update_reservation_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&status=${status}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status');
                });
        }
    }
</script>
</body>
</html>