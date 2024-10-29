<?php
// Database connection settings
$servername = "localhost"; // Change if needed
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "dishcovery"; // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all pending recipes
$sql = "SELECT * FROM recipeee WHERE status = 'pending'";
$result = $conn->query($sql);

// Start output buffer
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Approve Recipes</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Pending Recipes</h1>
        <div class="row">
            <?php
            // Check if there are any pending recipes
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($recipe = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    if (!empty($recipe['image_path'])) {
                        echo '<img src="' . htmlspecialchars($recipe['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($recipe['dish_name']) . '">';
                    }
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($recipe['dish_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($recipe['recipe']) . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Category: ' . htmlspecialchars($recipe['category']) . '</small></p>';
                    
                    // Approve Form
                    echo '<form method="POST" action="approverecipe.php" style="display:inline;">';
                    echo '<input type="hidden" name="id" value="' . $recipe['id'] . '">';
                    echo '<button type="submit" class="btn btn-success mx-2">Approve</button>';
                    echo '</form>';

                    // Reject Form
                    echo '<form method="POST" action="reject.php" style="display:inline;">';
                    echo '<input type="hidden" name="id" value="' . $recipe['id'] . '">';
                    echo '<button type="submit" class="btn btn-danger">Reject</button>';
                    echo '</form>';

                    echo '</div>'; // Close card-body
                    echo '</div>'; // Close card
                    echo '</div>'; // Close column
                }
            } else {
                echo '<p>No pending recipes found.</p>';
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Flush output buffer and close connection
ob_end_flush();
?>
