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

<input id="search">
<button onclick="getrecipe(document.getElementById('search').value)">Search Ingredients</button>
<div id="output"></div>
<a href="" id="sourceLink"></a>

<script>

function getsource(id) {
    $.ajax({
        url:"https://api.spoonacular.com/recipes/"+id+"/information?apiKey=f03a41647d14469b9841ab4eca7cd650",
        success:function(res){
            
            document.getElementById("sourceLink").innerHTML += res.sourceUrl + "<br>"
            document.getElementById("sourceLink").href += res.sourceUrl
            //return res.sourceUrl;
        } 
    });
}

allergens = document.getElementById("usrAllergens").value;
diet = document.getElementById("usrDiets").value;

function getrecipe(q){
    $.ajax({
        
        url:"https://api.spoonacular.com/recipes/search?apiKey=f03a41647d14469b9841ab4eca7cd650&number=2&query="+q+"&diet="+diet+"&intolerances"+allergens,
        success:function(res){
            document.getElementById("output").innerHTML= "";
            for(var i=0; i<res.results.length;i++){
                
                //document.getElementById("output").innerHTML+="<h1>"+res.results[i].title+"</h1><br><a href='"+getsource(res.results[i].id)"'>
                //<img src='"+res.baseUri+res.results[i].image+"'width='400'></img></a><br> ready in "+res.results[i].readyInMinutes+" minutes"
                //getsource(res.results[i].id)
                
                // want it to also take into account user preferences
                document.getElementById("output").innerHTML+="<h1>"+res.results[i].title+"</h1><br><img src='"+res.baseUri+res.results[i].image+"'width='400'></img><br> ready in "
                +res.results[i].readyInMinutes+" minutes"
                getsource(res.results[i].id)
            }
        }
    });
}
</script>
</body>
</html>
