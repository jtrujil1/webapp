<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seach Bar Php</title>
<link rel = "stylesheet" href = "searchBar.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
<?php

	//establish connection info
$server = "localhost";// your server
$userid = "u8ydcziwg5th2"; // your user id
$pw = "cs20JadeDelight**!"; // your pw
$db= "dbbofyy3lepmak"; // your database
		
// Create connection
$conn = new mysqli($server, $userid, $pw );

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}	
$id = '1234';
//select the database
$conn->select_db($db);

	//run a query
$sql = "SELECT `allergens`, `diet` FROM `preferences` WHERE `userid` LIKE '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usrAllergens = $row["allergens"];
        $usrDiets = $row["diet"];
    }
} else {
    echo "No results";
}	

echo "<input id='usrAllergens' value= '" . $usrAllergens."'> ";
echo "<input id='usrDiets' value= '" . $usrDiets."'> ";
//close the connection	
$conn->close();

?>

<div id = "wrapper">
    <img id = 'logo' src="images/Foodscape.jpg">
    <input id='search'>
    <button id="searchButton" onclick="getrecipe(document.getElementById('search').value)">Search Ingredients</button>
    <div id="output"></div>
</div>

<script>

function getsource(id, i) {
    var ret = "";
    $.ajax({
        url:"https://api.spoonacular.com/recipes/"+id+"/information?apiKey=0bab59a4d2c04015b66baba96d05e71e",
        success:function(res){
            
            console.log(res.sourceUrl);
            
            $("a[href^='templink" + i.toString() +"' ]")
                .each(function () {
                this.href = this.href.replace("http://neyak.sgedu.site/templink" + i.toString(), res.sourceUrl);
            });
        } 
    });
}

allergens = document.getElementById("usrAllergens").value;
diet = document.getElementById("usrDiets").value;

function getrecipe(q){
    $.ajax({
        
        url:"https://api.spoonacular.com/recipes/search?apiKey=0bab59a4d2c04015b66baba96d05e71e&number=2&query="+q+"&diet="+diet+"&intolerances"+allergens,
        success:function(res){
            if (q == "") {
              alert("No results. Please enter ingredients");
              return;
            }
            document.getElementById("output").innerHTML= "";
            
            if (res.results.length == 0) {
              alert("No results. Please enter new ingredients");
              return;
            }

            for(var i=0; i<res.results.length;i++){

                document.getElementById("output").innerHTML+="<h1>"+res.results[i].title+"</h1><br><a href='templink" + i.toString() +"' target='_blank'><img src='"+
                res.baseUri+res.results[i].image+"'width='400'></img></a><br> ready in "+res.results[i].readyInMinutes+" minutes";

                getsource(res.results[i].id, i);
                
            }
        }
    });
}
</script>
</body>
</html>
