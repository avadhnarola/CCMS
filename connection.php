<?php 
$conn = mysqli_connect("localhost", "root", "", "ccms");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>