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

<p class="userInfo"><label>Name</label>: <input type="text"  name='name' /></p>

<p class="userInfo"><label>Allergies</label>: </p>
Eggs<input type="checkbox" class="userInfo" name="allergen[]" value="egg"><br>
Dairy<input type="checkbox" class="userInfo" name="allergen[]" value="dairy"><br>
Gluten<input type="checkbox" class="userInfo" name="allergen[]" value="gluten"><br>
Grain<input type="checkbox" class="userInfo" name="allergen[]" value="grain"><br>
Peanut<input type="checkbox" class="userInfo" name="allergen[]" value="peanut"><br>
Seafood<input type="checkbox" class="userInfo" name="allergen[]" value="seafood"><br>
Sesame<input type="checkbox" class="userInfo" name="allergen[]" value="sesame"><br>
Shellfish<input type="checkbox" class="userInfo" name="allergen[]" value="shellfish"><br>
Soy<input type="checkbox" class="userInfo" name="allergen[]" value="soy"><br>
Sulfite<input type="checkbox" class="userInfo" name="allergen[]" value="sulfite"><br>
Tree Nut<input type="checkbox" class="userInfo" name="allergen[]" value="treenut"><br>
Wheat<input type="checkbox" class="userInfo" name="allergen[]" value="wheat"><br>

<p class="userInfo"><label>Diet</label>: </p>
Gluten Free<input type="checkbox" class="userInfo" name="diet[]" value="glutenfree"><br>
Ketogenic<input type="checkbox" class="userInfo" name="diet[]" value="ketogenic"><br>
Vegetarian<input type="checkbox" class="userInfo" name="diet[]" value="vegetarian"><br>
Lacto-Vegetarian<input type="checkbox" class="userInfo" name="diet[]" value="lacto-vegetarian"><br>
Ovo-Vegetarian<input type="checkbox" class="userInfo" name="diet[]" value="ovo-vegetarian"><br>
Vegan<input type="checkbox" class="userInfo" name="diet[]" value="vegan"><br>
Pescetarian<input type="checkbox" class="userInfo" name="diet[]" value="pescetarian"><br>
Paleo<input type="checkbox" class="userInfo" name="diet[]" value="paleo"><br>
Primal<input type="checkbox" class="userInfo" name="diet[]" value="primal"><br>
Low FOODMAP<input type="checkbox" class="userInfo" name="diet[]" value="lowfoodmap"><br>
Whole30<input type="checkbox" class="userInfo" name="diet[]" value="whole30"><br>


<input type = "submit" value = "Update Preferences" />

</body>
</html>
