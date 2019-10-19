<?php
$sql = "SELECT FirstName, LastName 
                FROM customers 
                WHERE Email=?";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $userName);

$userName = $_SESSION['username'];

$stmt->execute();

$stmt->bind_result($firstName, $lastName);
$stmt->fetch();
$stmt->close();
?>
