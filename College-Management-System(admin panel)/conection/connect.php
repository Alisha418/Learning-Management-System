<!-- <?php
// mysql_connect("127.0.0.1","root", "12345678",'project2',3307) or die("No Connection");
// mysql_select_db("assignment") or die("No Database connected!");
?> -->

<!-- <?php
//all the variables defined here are accessible in all the files that include this one
// $con= new mysqli('127.0.0.1', 'root', '12345678', 'project2',3307)or die("Could not connect to mysql".mysqli_error($con));

?> -->

<?php
// Establishing the connection using MySQLi
$conn = mysqli_connect("localhost", "root", "", "edusphere2", 3307);

// Checking if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully to the database!";
}
?>
<!-- #662d91 -->
