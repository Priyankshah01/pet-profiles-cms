<!-- <?php
$host = "localhost";
$user = "root"; 
$pass = "";     
$dbname = "dog_buddy_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?> -->

<?php
// Pet Profiles CMS - Database Connection

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'pet_profiles_cms');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch(PDOException $e) {
    // Log error and show user-friendly message
    error_log("Database connection failed: " . $e->getMessage());
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}

// Helper function to execute queries safely
function executeQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        error_log("Query execution failed: " . $e->getMessage());
        throw new Exception("Database operation failed");
    }
}

// Helper function to get all pets
function getAllPets($pdo) {
    $sql = "SELECT * FROM pets ORDER BY created_at DESC";
    return executeQuery($pdo, $sql)->fetchAll();
}

// Helper function to get pet by ID
function getPetById($pdo, $id) {
    $sql = "SELECT * FROM pets WHERE id = ?";
    return executeQuery($pdo, $sql, [$id])->fetch();
}

// Helper function to get all breeds
function getAllBreeds($pdo) {
    $sql = "SELECT * FROM breeds ORDER BY breed_name";
    return executeQuery($pdo, $sql)->fetchAll();
}

// Helper function to verify admin login
function verifyAdmin($pdo, $username, $password) {
    $sql = "SELECT id, username, password FROM admins WHERE username = ?";
    $stmt = executeQuery($pdo, $sql, [$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        return $admin;
    }
    return false;
}

// Helper function to add new pet
function addPet($pdo, $name, $breed, $story, $photo = null) {
    $sql = "INSERT INTO pets (name, breed, story, photo) VALUES (?, ?, ?, ?)";
    return executeQuery($pdo, $sql, [$name, $breed, $story, $photo]);
}

// Helper function to update pet
function updatePet($pdo, $id, $name, $breed, $story, $photo = null) {
    if ($photo) {
        $sql = "UPDATE pets SET name = ?, breed = ?, story = ?, photo = ? WHERE id = ?";
        return executeQuery($pdo, $sql, [$name, $breed, $story, $photo, $id]);
    } else {
        $sql = "UPDATE pets SET name = ?, breed = ?, story = ? WHERE id = ?";
        return executeQuery($pdo, $sql, [$name, $breed, $story, $id]);
    }
}

// Helper function to delete pet
function deletePet($pdo, $id) {
    $sql = "DELETE FROM pets WHERE id = ?";
    return executeQuery($pdo, $sql, [$id]);
}
?>
