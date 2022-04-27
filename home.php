<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-code" content="loading.php">
        <meta name="google-signin-client_id" content="764009503051-2ii3ko9tqvj69aoielqgbv4a2tfgrfqm.apps.googleusercontent.com">
        <title>Foodscape</title>
        <link rel = "stylesheet" href = "home.css">
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

        //run a query
        $sql = "SELECT `recipeid` FROM `recipes` WHERE `userid` LIKE '$id'";
        $result = $conn->query($sql);

        $usrRecipes = "";

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $usrRecipes .= ($row["recipeid"] . ",");
            }
        } else {
            echo "No results";
        }	

        echo "<input id='usrRecipes' value= '" . $usrRecipes."'> ";

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
                    url:"https://api.spoonacular.com/recipes/"+id+"/information?apiKey=f03a41647d14469b9841ab4eca7cd650",
                    success:function(res){
                        
                        console.log(res.sourceUrl);
                        
                        $("a[href^='templink" + i.toString() +"' ]")
                            .each(function () {
                            this.href = this.href.replace("https://alejandrat.sgedu.site/templink" + i.toString(), res.sourceUrl);
                        });
                    } 
                });
            }

        allergens = document.getElementById("usrAllergens").value;
        diet = document.getElementById("usrDiets").value;

        function getrecipe(q){
            $.ajax({
                
                url:"https://api.spoonacular.com/recipes/search?apiKey=f03a41647d14469b9841ab4eca7cd650&number=8&query="+q+"&diet="+diet+"&intolerances"+allergens,
                success:function(res){
                    recipes = (document.getElementById("usrRecipes").value).split(",");

                    if (q == "") {
                        alert("No results. Please enter ingredients");
                        return;
                    }
                    document.getElementById("output").innerHTML= "";
                    
                    if (res.results.length == 0) {
                        document.getElementById("output").innerHTML = "<div class='container'><h1>No results, please enter other ingredients.</h1></div>";
                        return;
                    }

                    for(var i=0; i<res.results.length;i++){
                        istr = i.toString();
                        newElem = "<div class='container'><h1 id ='recipeName" + istr + "'>" + res.results[i].title+ "</h1><br><a id ='link" + istr + "' href='templink" + istr + "' target='_blank'><img id ='photo" + istr + "' src='"+res.baseUri+res.results[i].image+"'width='400'></img></a><br><div class='cont'>ready in<a id ='readyInMinutes" + istr + "'> "+res.results[i].readyInMinutes+"</a> minutes</div>";

                        if (recipes.includes((res.results[i].id).toString())) {
                            newElem += "<button class='saveButton' onclick='deleteRecipe(" + istr + ", " + res.results[i].id + ")'>Remove</button></div><br>";
                        } else {
                            newElem += "<button class='saveButton' onclick='saveRecipe(" + istr +  ", " + res.results[i].id + ")'>Save</button></div><br>";
                        }
                        
                        document.getElementById("output").innerHTML += newElem;

                        getsource(res.results[i].id, i);   
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

        function saveRecipe(i, recipeid) {
            console.log("save recipe");
            setCookies(i, recipeid);
            document.getElementsByClassName("saveButton")[i].innerHTML = "Remove";
            document.getElementsByClassName("saveButton")[i].onclick = function() { deleteRecipe(i, recipeid); }
            window.open("/recipes.php");
        }

        function deleteRecipe(i, recipeid) {
            console.log("delete recipe");
            setCookies(-1, recipeid);
            updateRecipeIds(recipeid);
            document.getElementsByClassName("saveButton")[i].innerHTML = "Save";
            document.getElementsByClassName("saveButton")[i].onclick = function() { saveRecipe(i, recipeid); }
            window.open("/recipes.php");
        }

        function updateRecipeIds(recipeid) {
            recipes = (document.getElementById("usrRecipes").value).split(",");
            index = recipes.indexOf(recipeid.toString());
            recipes.splice(index, 1);
            str = ""
            for (i = 0; i < recipes.length; i++) {
                str += (recipes[i] + ",");
            }
            document.getElementById("usrRecipes").value = str;
        }

        function setCookies(i, recipeid) {
            var date = new Date();
            date.setTime(date.getTime()+(5*1000));
            var expires = "; expires="+date.toGMTString();

            if (i != -1) {
                document.cookie = "recipeName=" + document.getElementById("recipeName" + i).innerHTML + expires + "; path=/";
                document.cookie = "readyInMinutes=" + document.getElementById("readyInMinutes" + i).innerText  + expires + "; path=/";
                document.cookie = "photo=" + document.getElementById("photo" + i).src + expires + "; path=/";
                document.cookie = "link=" + document.getElementById("link" + i) + expires + "; path=/";
                document.cookie = "func=save"+ expires + "; path=/";
            } else {
                document.cookie = "func=delete"+ expires + "; path=/";
            }
            document.cookie = "recipeid=" + recipeid + expires + "; path=/";
        }

        </script>
        <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    </body>
</html>
