<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    
    // Validate and sanitize the data (you can add more validation if needed)
    $name = trim($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $subject = trim($subject);
    $message = trim($message);
    
    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       //store the data in a database

        
        $conn = new mysqli("localhost", "username", "password", "database_name");
        
        // Checking connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and bind the statement
        $stmt = $conn->prepare("INSERT INTO your_table_name (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo " Thank You For Sharing Your Input!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid email address!";
    }
}
?>
