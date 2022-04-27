<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update Perferences</title>
<link rel="stylesheet" href="foodscape.css">
</head>

<body>
<?php
$allergy = $_GET['allergen'];
$allergyvalues = "";

foreach ($allergy as $value){ 
    $allergyvalues .= $value;
    $allergyvalues .= ",";
}

$diet = $_GET['diet'];

$dietvalues = "";

foreach ($diet as $value){ 
    $dietvalues .= $value;
    $dietvalues .= ",";
}

//establish connection info
$server = "localhost";// your server
$userid = "uqqa23cg6ifpt"; // your user id
$pw = "foodscape"; // your pw
$db= "dbbfgj50gawiki"; // your database

// Create connection
$conn = new mysqli($server, $userid, $pw );

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//select the database
$conn->select_db($db);

$id = $_COOKIE["userId"];

//run a query
$sql = "UPDATE `preferences` SET `allergens` = '$allergyvalues', `diet` =  '$dietvalues' WHERE `userid` = '$id'";

$result = $conn->query($sql);

//close the connection
$conn->close();

$url = "https://alejandrat.sgedu.site/home.php";

echo "<script>window.location = '$url'</script>";
?>
</body>
</html>
