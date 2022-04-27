<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-code" content="loading.php">
        <meta name="google-signin-client_id" content="764009503051-2ii3ko9tqvj69aoielqgbv4a2tfgrfqm.apps.googleusercontent.com">
        <title>Foodscape</title>
        <link rel = "stylesheet" href = "recipes.css">
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


        echo "<h1>My Recipes</h1>";
        //select the database
        $conn->select_db($db);

        //Save or delete recipe if set
        if (isset($_COOKIE['func'])) {
            $func = $_COOKIE["func"];
            $rId = $_COOKIE['recipeid'];
            if ($func == save) {
                $rname = $_COOKIE['recipeName'];
                $rIM = $_COOKIE['readyInMinutes'];
                $photo = $_COOKIE['photo'];
                $link = $_COOKIE['link'];

                $sql = "INSERT INTO `recipes` (`userid`, `recipeName`, `readyInMinutes`, `photo`, `link`, `recipeid`, `id`) VALUES ('$id', '$rname', '$rIM', '$photo', '$link', '$rId', NULL)";
                $result = $conn->query($sql);
            } else {
                $sql = "DELETE FROM `recipes` WHERE `userid` LIKE '$id' AND `recipeid` LIKE '$rId';";
                $result = $conn->query($sql);

            }
        }

        //run a query
        $sql = "SELECT * FROM `recipes` WHERE `userid` LIKE '$id'";
        $result = $conn->query($sql);

        echo "<div id='output'>";

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $newElem = "<div class='container'><h2>" . $row["recipeName"] . "</h2><br><a href='". $row["link"] ."' target='_blank'><img src='" . $row["photo"] . "'width='400'></img></a><br> ready in " . $row["readyInMinutes"] . " minutes</div><br>";
                
                echo $newElem;
            }
        } else {
            echo "<h2>You have no saved recipes</h2>";
        }

        echo "</div>";

        //close the connection	
        $conn->close();
        ?>

        <script>        
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
