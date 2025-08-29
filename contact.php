<?php
// Database config
$host = "localhost";      // usually 'localhost'
$dbname = "portfolio";    // your database name
$username = "root";       // your DB username (default is 'root' in XAMPP)
$password = "root";           // your DB password (empty in XAMPP by default)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h2>Invalid email format.</h2>";
        exit;
    }

    // Connect to database
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set PDO error mode
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert query
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        // Execute
        $stmt->execute();

        echo "<h2>Thank you! Your message has been saved.</h2>";

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
} else {
    echo "<h2>Invalid Request.</h2>";
}
?>
