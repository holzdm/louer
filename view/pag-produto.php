<?php 
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../pag-login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pag do produto</title>
</head>
<body>
    
</body>
</html>