<?php
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
$name = $_COOKIE["name"];
$userImg = $_COOKIE["userImg"];

//run a query
$sql = "SELECT * FROM `preferences` WHERE `userid` LIKE '$id'";

$result = $conn->query($sql);

$url = "https://alejandrat.sgedu.site";

if ($result->num_rows == 0) {
    $url .= "/preferences.php";
    $sql = "INSERT INTO `preferences` (`name`, `allergens`, `diet`, `userid`, `userImg`) VALUES ('$name', '', '', '$id', '$userImg')";
    $result = $conn->query($sql);
} else {
    $url .= "/home.php";
}

echo "<script>window.location = '$url'</script>";

//close the connection
$conn->close();
exit();
?>