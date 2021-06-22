<!DOCTYPE html>
<html>
<body>

<h2>Wiring Calculator</h2>


<?php

$servername = "localhost";
$port = "3307";
$db = "wiring_calculation";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $db, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$length = $_GET["length"];
$width = $_GET["Width"];
$area = $length*$width;
$sql = "SELECT noOfBulbs FROM bulb where size =" . $area ;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
   //output data of each row
 while($row = $result->fetch_assoc()) {
    echo "No Of Bulbs need: " . $row["noOfBulbs"];
  }
} else {
  echo "0 results";
}
$conn->close();

?>


<input type="button" value="Back">

</body>
</html>
