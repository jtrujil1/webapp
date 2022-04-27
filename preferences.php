<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Foodscape Preferences</title>
<link rel="stylesheet" href="prefstyle.css">
<link rel = "stylesheet" href = "topbar.css">
</head>
<body>
<?php
$name = $_COOKIE["name"];
$userImg = $_COOKIE["userImg"];

// Create topbar with user image and 
echo "<div class='topbar'><h2 style='color:#233D4D; align-self:center;'>Hi, ". $name . ".</h2>";

echo "<div class='dropdown'>
    <button class='dropbtn' style='background-image: url(". $userImg . ");'></button><div class='dropdown-content'>
        <a href='home.php'>
            <img src='images/home.png' width='20' height='15'> Home</a>
        <a href='preferences.php'>
            <img src='images/settings.png' width='20' height='15'> My Preferences</a>
        <a href='recipes.php'>
            <img src='images/save.png' width='20' height='15'> My Recipes</a>
        <a href='javascript:void(0);' onclick='signOut();'>
            <img src='images/signout.png' width='20' height='15'> Sign Out</a></div></div></div>";
?>
<div id="container">
<img id="logo" src="images/Foodscape.jpg">
<h1>Your Preferences</h1>
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

echo "<table><tr><td>";

echo "<p class='userInfo'><label>Allergies</label>: </p>";
for ($i = 0; $i < count($allergens); $i++) {
    $item = $allergens[$i];
    $output = "<input type='checkbox' class='userInfo' name='allergen[]' value='" . $item . "'";
    if (in_array($item, $usrAllergens)){
        $output .=  "checked";
    }
    echo $output . ">" .$item ."<br>";
}

echo "</td><td>";

echo "<p class='userInfo'><label>Diet</label>: </p>";
for ($i = 0; $i < count($diets); $i++) {
    $item = $diets[$i];
    $output = "<input type='checkbox' class='userInfo' name='diet[]' value='" . $item . "'";
    if (in_array($item, $usrDiets)){
        $output .=  "checked";
    }
    echo $output . ">" .$item ."<br>";
}

echo "</td></tr><table>";

echo "<input type = 'submit' value = 'Update Preferences'/></form>";

//close the connection
$conn->close();
exit();
?>
</div>
</body>
</html>