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
            padding: 20px;
            background-color: #fefefa;
        }

        .main-content h2 {
            color: #43302e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-weight: ;
        }
        th {
            background-color: #f4f4f4;
            color: #43302e;
            text-transform: uppercase;
        }
        .view-id-btn {
            padding: 6px 12px;
            background-color: #8B4513;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .view-id-btn:hover {
            background-color:  #964b00;
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
            width: 80%;
            max-width: 700px;
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
        .modal-image {
            max-width: 100%;
            max-height: 70vh;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo">Admin Panel</div>
        <ul class="nav-links">
            <li><a href="adminpanel.php">Home</a></li>
            <li><a href="#">User Register</a></li>
            <li><a href="reservationadmin.php">Reservation</a></li>
            <li><a href="calendareditor.php">Calendar Editor</a></li>
        </ul>
        <div class="logout">Log Out</div>
    </div>
    <div class="main-content">
        <h2>User Registrations</h2>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Valid ID</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include 'connect.php';

            $query = "SELECT * FROM user_register ORDER BY id ASC";
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>";

                if ($row['valid_id_image']) {
                    echo "<button class='view-id-btn' onclick='showImage(" . $row['id'] . ")'>View ID</button>";
                } else {
                    echo "No ID uploaded";
                }
                echo "</td>";
                echo "</tr>";
            }

            ?>
            </tbody>
        </table>

        <!-- Modal for displaying the image -->
        <div id="imageModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <img id="modalImage" class="modal-image" src="" alt="Valid ID">
            </div>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("modalImage");
            var span = document.getElementsByClassName("close")[0];

            function showImage(id) {
                modal.style.display = "block";
                modalImg.src = "getImage.php?id=" + id;
            }

            // Close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Close the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            }
        </script>

    </div>
</div>
</body>
</html>