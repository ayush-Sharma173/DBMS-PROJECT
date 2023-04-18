<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$password = 'password123';
$dbname = 'minipro';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
$conn = mysqli_connect("localhost", "root", "password123", "minipro");
    session_start();
    
    
    if(!isset($_SESSION['sess_user'])){
        header('Location: index.php');
    }
    $student_id = $_SESSION['sess_user'];
// Retrieve the data from the students table
$roll=$student_id;

// Get the company name from the URL parameter
$company_name = $_GET['company'];
$role = $_GET['role'];

// Insert the data into a new table named registrations
$stmt = $pdo->prepare("
    INSERT INTO registrations (roll, company_name,role)
    VALUES (:roll, :company_name,:role)
");
$stmt->execute([
    ':roll' => $roll,
    ':company_name' => $company_name,
    ':role'=> $role,
]);

echo "Registration successful!";
?>
