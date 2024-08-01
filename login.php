<?php
session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "Register"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['email']) && isset($_POST['password'])){
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM form WHERE email=? AND password=?");
    $stmt->bind_param("ss", $Email, $Password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $Email;
        header("Location: Acceuil.html");
        echo "Connexion réussie !";
    } else {
        echo "Identifiants incorrects.";
    }
}


$stmt->close();
$conn->close();
?>
