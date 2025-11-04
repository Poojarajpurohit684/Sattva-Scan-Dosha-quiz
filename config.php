<!-- 
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dosha_quiz';

$conn = new mysqli($host, $user, $password, $database);

// Check connection properly
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Database Connected Successfully";   -->

<?php
$servername = "localhost";
$username = "root";   // or your MySQL username
$password = "";       // or your MySQL password
$dbname = "dosha_quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Database Connected Successfully";  
?>
