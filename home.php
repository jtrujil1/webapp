<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-code" content="loading.php">
        <meta name="google-signin-client_id" content="764009503051-2ii3ko9tqvj69aoielqgbv4a2tfgrfqm.apps.googleusercontent.com">
        <title>Foodscape</title>
        <link rel = "stylesheet" href = "searchBar2.css">
        <link rel = "stylesheet" href = "topbar.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>

    <body>
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
        
        $id = $_COOKIE["userId"];
        $name = $_COOKIE["name"];
        $userImg = $_COOKIE["userImg"];

        // Create topbar with user image and 
        echo "<div class='topbar'><h1 style='color: rgb(206, 148, 23); align-self:center;'>Hi, ". $name . ".</h1>";

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
        <button id="searchButton" onclick="getrecipe(document.getElementById('search').value)">Search Ingredients</button>
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
        
        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
                window.open("/login.html","_self");
            });
            }

            function onLoad() {
            gapi.load('auth2', function() {
                gapi.auth2.init();
            });
        }
        </script>
        <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    </body>
</html>
