<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update Perferences</title>
<link rel="stylesheet" href="foodscape.css">
</head>

<body>
<?php

$name = $_GET['name'];
$allergy = $_GET['allergen'];
$allergyvalues = "";

foreach ($allergy as $value){ 
    $allergyvalues .= $value;
    $allergyvalues .= " ";
}

$diet = $_GET['diet'];

$dietvalues = "";

foreach ($diet as $value){ 
    $dietvalues .= $value;
    $dietvalues .= " ";
}

//establish connection info
$server = "localhost";// your server
$userid = "ulsqkho6yu4fu"; // your user id
$pw = "foodscape"; // your pw
$db= "dbsqu7dtzilu6t"; // your database

// Create connection
$conn = new mysqli($server, $userid, $pw );

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully<br>";

//select the database
$conn->select_db($db);

//run a query
$sql = "INSERT INTO `preferences` (`id`, `name`, `allergens`, `diet`, `userid`) VALUES (NULL, '$name', '$allergyvalues', '$dietvalues', '')";
$result = $conn->query($sql);

//close the connection
$conn->close();

?>
</body>
</html>
