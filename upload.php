<?php
$host = 'localhost'; // Database host
$dbname = 'dishcovery'; // Replace with your database name
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

// Create a connection
$connection = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Clean and validate content
       $dishName = trim($_POST['photoTitle']);
       $recipe = trim($_POST['photoDescription']);
       $category = trim($_POST['category']);
   
       $media_url = ''; // Initialize media_url
   
       // Handle file upload
       if (!empty($_FILES['media']['name'])) {
           $target_dir = "upload/";
           $target_file = $target_dir . basename($_FILES['media']['name']);
           move_uploaded_file($_FILES['media']['tmp_name'], $target_file);
           $media_url = $target_file;
       }
   
       // Using prepared statements to prevent SQL injection
       $stmt = $connection->prepare("INSERT INTO recipeee (dish_name, recipe, category, image_path) VALUES (?, ?, ?, ?)");
       if ($stmt === false) {
           die('Prepare failed: ' . htmlspecialchars($connection->error)); // Check if prepare failed
       }
   
       // Bind parameters, including the post_type from the dropdown
       $stmt->bind_param("ssss", $dishName, $recipe, $category, $media_url);
   
       // Execute the statement and check for errors
       if ($stmt->execute()) {
           echo "<p style='color: greeen;'>Inserted Succesfully</p>";
       } else {
           echo "Error: " . htmlspecialchars($stmt->error); // Display error message
       }
   
       // Close the statement
       $stmt->close();
}

$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upload.css"> <!-- Link to your CSS file -->
    <title>Upload Recipe</title>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Recipe</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="photoTitle">Dish name:</label>
                <input type="text" id="photoTitle" name="photoTitle" required>
            </div>
            <div class="form-group">
                <label for="photoDescription">Recipe and Procedure:</label>
                <textarea id="photoDescription" name="photoDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="appetizer">Appetizer</option>
                    <option value="main_course">Main Course</option>
                    <option value="dessert">Dessert</option>
                    <option value="snack">Snack</option>
                    <option value="salads">Salads</option>
                    <option value="side_dishes">Side Dishes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Select Photo:</label>
                <input type="file" name="media" id="media" class="form-control" accept="image/*" onchange="previewMedia(event)">
            </div>
            
            <button type="submit">Upload</button>
        </form>
        <div id="message" style="margin-top: 20px; color: green;"></div> <!-- Notification area -->
    </div>
</body>
</html>