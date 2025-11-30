<?php
require "db.php";

$users = getUsers($conn);
echo json_encode($users);

$conn->close();
?>

