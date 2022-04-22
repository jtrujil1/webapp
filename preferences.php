<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Foodscape Preferences</title>
<link rel="stylesheet" href="prefstyle.css">
</head>
<body>

<h1>Foodscape Preferences</h1>
<form method='get' action = 'process1.php'>

<?php
$allergens = array("Eggs", "Dairy", "Gluten", "Grain", "Peanut", "Seafood", "Sesame", "Shellfish", "Soy", "Sulfite", "Tree Nut", "Wheat");

$diets = array("Gluten Free", "Ketogenic", "Vegetarian", "Lacto-Vegetarian", "Ovo-Vegetarian", "Vegan", "Pescetarian", "Paleo", "Primal", "Low FOODMAP", "Whole30");

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

$id = $_COOKIE["userId"];

//select the database
$conn->select_db($db);

//run a query
$sql = "SELECT `allergens`, `diet` FROM `preferences` WHERE `userid` LIKE '$id'";

$result = $conn->query($sql);

$usrAllergens = array();
$usrDiets = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usrAllergens = explode(",", $row["allergens"]);
        $usrDiets = explode(",", $row["diet"]);
    }
} else {
    echo "No results";
}

echo "<p class='userInfo'><label>Allergies</label>: </p>";
for ($i = 0; $i < count($allergens); $i++) {
    $item = $allergens[$i];
    $output = $item . "<input type='checkbox' class='userInfo' name='allergen[]' value='" . $item . "'";
    if (in_array($item, $usrAllergens)){
        $output .=  "checked";
    }
    echo $output . "><br>";
}

echo "<p class='userInfo'><label>Diet</label>: </p>";
for ($i = 0; $i < count($diets); $i++) {
    $item = $diets[$i];
    $output = $item . "<input type='checkbox' class='userInfo' name='diet[]' value='" . $item . "'";
    if (in_array($item, $usrDiets)){
        $output .=  "checked";
    }
    echo $output . "><br>";
}

echo "<input type = 'submit' value = 'Update Preferences'/></form>";

//close the connection
$conn->close();
exit();
?>

</body>
</html>
