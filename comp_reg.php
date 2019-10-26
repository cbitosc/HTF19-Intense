<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"test");

// Check connection
if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}
echo "Connected successfully";

$sql="SELECT * FROM POWERDB";
$rows = mysqli_query($conn,$sql);
$num = mysqli_num_rows($rows);
//$sql1 = "INSERT INTO POWERDB VALUES($num,'Kousthubha','12314','Miyarp','tel','hyd','power shivareddy');";

$sql="INSERT into POWERDB values($num,'$_POST[name]','$_POST[aadhar]','$_POST[region]','$_POST[district]','$_POST[state]',' ')";

mysqli_query($conn,$sql);
include('retrive.php');
?>
