<?php
include('db.php');
$query = "SELECT * FROM therapists";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Name: " . $row['name'] . "<br>";
        echo "Specialization: " . $row['specialization'] . "<br>";
        echo "Contact: " . $row['contact'] . "<br>";
        echo "Email: " . $row['email'] . "<br><hr>";
    }
} else {
    echo "No therapists found!";
}
?>
