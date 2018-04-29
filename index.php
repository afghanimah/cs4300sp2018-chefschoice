<!DOCTYPE html>

<?php
	$firstFoodItem = NULL;
?>

<html>
<header>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/ionicons-2.0.1/css/ionicons.min.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/master.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/form.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/ionicons.min.css" media="all"/>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Source+Sans+Pro:200" rel="stylesheet">
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/slide.js"></script>
	<title>Chef's Choice</title>
</header>
<body>
	<div id="names_topright">
		Abraham Ghanimah (afg63)
		Abrahm Magana (adm264)
		Johanna Smith-Palliser (jls628)
		Oscar Barraza (odb5)
	</div>

	<div id="chef_bottomright">
		<img src="images/chef.png" alt="Cartoon chef" />
	</div>

	<div id='contentContainer'>
		<div id='content'>
			<h1><a href="">Chef's Choice</a></h1>

			<form method="post" action="index.php" name="search-form">
				<div class="center">
					When I am
					<div class="group">
						<script>
							function autosuggest(str) {
								console.log(str);
								if (str.length == 0) {
									console.log("_blank")
									return;
								} else {
									var xmlhttp = new XMLHttpRequest();
									xmlhttp.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
											console.log(this.responseText);
											return(this.responseText);
										}
									};
									xmlhttp.open("GET", "phpserver.php?q=" + str, true);
									xmlhttp.send();
								}
							}
						</script>
						<input type="text" name="input-mood" id="mood" onkeyup="autosuggest(this.value)" value="<?php echo (isset($_POST['submit-query']) ? $_POST["input-mood"] : ""); ?>" required>
						<span class="bar"></span>
						<label>[mood]</label>
					</div>,
					<br />
					I eat
					<div class="group">
						<input type="text" name="input-food" value="<?php echo (isset($_POST['submit-query']) ? $_POST["input-food"] : ""); ?>" required>
						<span class="bar"></span>
						<label>[food]</label>
					</div>.

					<div id="advanced-search">
						<div id="adv-panel">Filter Recommendations</div>
						<div id="slide">

							<!-- <div class="group">
								<input type="text" name="input-nutrient" placeholder=""/>
								<span class="bar"></span>
								<label>[nutrient]</label>
							</div> -->

							<div class="group">
								<input type="text" name="input-exclude" placeholder=""/>
								<span class="bar"></span>
								<label>[exclude eggs, milk, ...]</label>
							</div>

							<br />

							<div id="dropdowns-container">
								<div class="custom-select">
									<select name="input-cuisine">
										<option disabled selected value>[cuisine]</option>
										<?php
										$cuisineArr = array("African", "Chinese", "Japanese", "Korean", "Vietnamese",
										"Thai", "Indian", "British", "Irish", "French", "Italian", "Mexican", "Spanish",
										"Middle Eastern", "Jewish", "American", "Cajun", "Southern", "Greek",
										"German", "Nordic", "Eastern European", "Caribbean", "Latin American");
										foreach ($cuisineArr as $cuisine) {
											echo '<option value=' . $cuisine . '> ' . $cuisine . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-diet">
										<option disabled selected value>[diet]</option>
										<?php
										$dietArr = array("Pescetarian", "Lacto vegetarian", "Ovo vegetarian", "Vegan", "Vegetarian");
										foreach ($dietArr as $diet) {
											echo '<option value=' . $diet . '> ' . $diet . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-intolerances">
										<option disabled selected value>[intolerances]</option>
										<?php
										$intolerancesArr = array("Dairy", "Egg", "Gluten", "Peanut", "Sesame",
										"Seafood", "Shellfish", "Soy", "Sulfite", "Tree nut", "Wheat");
										foreach ($intolerancesArr as $intol) {
											echo '<option value=' . $intol . '> ' . $intol . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-type">
										<option disabled selected value>[type]</option>
										<?php
										$typeArr = array("Main course", "Side", "Dessert", "Appetizer", "Salad",
										"Bread", "Breakfast", "Soup", "Beverage", "Sauce", "Drink");
										foreach ($typeArr as $type) {
											echo '<option value=' . $type . '> ' . $type . '</option>';
										}
										?>
									</select>
								</div>
							</div>


						</div>
					</div>

					<input type="submit" name="submit-query" value="Analyze"/>
				</div>

			</form>

		</div>
	</div>

	<div id="results">
		<?php
			include('format.php');
			if ($_POST['submit-query']) {
		?>
				<div id="dashboard">
					 <div id="userFoodRatingContainer"></div>
						 <script>
							 var colorScale = d3.scaleSequential(d3.interpolateRdYlGn);
							 var userFoodRatingHeight = 350;
							 var userFoodRatingWidth = 350;
							 var userFoodRatingSVG = d3.select("#userFoodRatingContainer").append("svg")
																				 .attr("height", userFoodRatingHeight)
																				 .attr("width", userFoodRatingWidth);

							 userFoodRatingSVG.append("circle")
							 .attr("cx", userFoodRatingHeight/2)
							 .attr("cy", userFoodRatingWidth/2)
							 .attr("r", 150)
							 .style("fill", colorScale(<?php echo $score; ?>));

							 userFoodRatingSVG.append("text")
							 .attr("x", userFoodRatingHeight/2)
							 .attr("y", userFoodRatingWidth/2)
							 .text(<?php echo $score*100; ?>+"%")
							 .style("alignment-baseline", "middle")
							 .style("text-anchor", "middle")
								 .attr("font-family", "Source Sans Pro")
								 .attr("font-size", "80px")
								 .attr("fill", "white");

							 userFoodRatingSVG.append("text")
							 .attr("x", userFoodRatingHeight/2)
							 .attr("y", 3*userFoodRatingWidth/5)
							 .text("<?php echo $foodInput; echo ((substr($foodInput,-1) == "s") ? " are" : " is");?> a")
							 .style("alignment-baseline", "hanging")
							 .style("text-anchor", "middle")
								 .attr("font-family", "Source Sans Pro")
								 .attr("font-size", "30px")
								 .attr("fill", "white");

							 userFoodRatingSVG.append("text")
							 .attr("x", userFoodRatingHeight/2)
							 .attr("y", 3*userFoodRatingWidth/5 + 30)
							 .text("<?php echo $rating; ?> choice!")
							 .style("alignment-baseline", "hanging")
							 .style("text-anchor", "middle")
								 .attr("font-family", "Source Sans Pro")
								 .attr("font-size", "30px")
								 .attr("fill", "white")
								 .attr("word-wrap", "break-word");

						</script>
					 <div id="userFoodNutrientsContainer">
						 <h2>Top nutrients in <span id="foodInput"><?php echo $foodInput;?></span>: </h2>
						 <ul>
							 <?php
							 $found = FALSE;
							 $matchNutrient = "vitamin b";
							 foreach (getNutrients($foodSearchItem) as $nutr => $amt){
								 echo "<li>" . $nutr . " (" . $amt . "% DV)</li>";
								 if (in_array(strtolower($nutr), $moodFood) && !$found) {
									 // echo "test";
				 						$matchNutrient = strtolower($nutr);
										// echo $matchNutrient;
										$found = true;
				 					}
							 }
							 // echo "match = " . $matchNutrient;
							 // echo array_search($matchNutrient, $moodFood);
							 $optimalMood = strtoupper(array_search($matchNutrient, $moodFood));
							 ?>
						 </ul>
					 </div>
					 <div id="userFoodOptimalMoodContainer"></div>
					 <script>
							 var userFoodOptimalMoodHeight = 350;
							 var userFoodOptimalMoodWidth = 350;
							 var userFoodOptimalMoodSVG = d3.select("#userFoodOptimalMoodContainer").append("svg")
							.attr("height", userFoodOptimalMoodHeight)
							.attr("width", userFoodOptimalMoodWidth);

							 userFoodOptimalMoodSVG.append("circle")
							 .attr("class", "userFoodOptimalMood")
							 .attr("cx", userFoodRatingHeight/2)
							 .attr("cy", userFoodRatingWidth/2)
							 .attr("r", 150)
								 .style("fill", "bisque");

							 userFoodOptimalMoodSVG.append("text")
							 .attr("x", userFoodRatingHeight/2)
							 .attr("y", userFoodRatingWidth/2)
							 .text("<?php echo $optimalMood; ?>")
							 	.attr("id", "optimalMoodSVG")
							 .style("alignment-baseline", "middle")
							 .style("text-anchor", "middle")
								 .attr("font-family", "Source Sans Pro")
								 .attr("font-size", "60px")
								 .attr("fill", "black")
								 .attr("word-wrap", "break-word");

							 userFoodOptimalMoodSVG.append("text")
							 .attr("x", userFoodRatingHeight/2)
							 .attr("y", userFoodRatingWidth/3 - 15)
							 .text("<?php echo $foodInput; echo ((substr($foodInput,-1) == "s") ? " are" : " is");?> best when")
							 .style("alignment-baseline", "hanging")
							 .style("text-anchor", "middle")
								 .attr("font-family", "Source Sans Pro")
								 .attr("font-size", "25px")
								 .attr("fill", "black")
								 .attr("word-wrap", "break-word");
						 </script>
				 </div>
				 <?php
				 //displays results from query
				 foreach($parsedResponse["results"] as $item) {
					 if ($firstFoodItem == NULL){
						 $firstFoodItem = $item;
					 }
					 $foodItem = getFoodByID($item["id"], $clientArray);?>
					 <div class="resultsCard">
						 <?php
						 $imageExtension = explode(".", $item["image"]);
						 ?>
						 <a href="<?php echo $foodItem["sourceUrl"];?>" target="_blank">
							 <div class="resultsImage">
								 <img src=<?php echo "https://webknox.com/recipeImages/".$item["id"]."-556x370.".$imageExtension[1]?> alt="results image">
							 </div>
						 <div class="resultsInfo">
							 <div class="resultsText">
								 <h1><?php echo $item["title"]?></h1>
								 <ul>
									 <li><span class="icon ion-thumbsup"></span><?php echo $foodItem["aggregateLikes"]?></span></li>
									 <li><span class="icon ion-trophy"></span><?php echo "Score: ".$foodItem["spoonacularScore"]?></span></li>
									 <li><span class="icon ion-heart"></span><?php echo "Health Score: ".$foodItem["healthScore"]?></span></li>
								 </ul>
								 <ul>
									 <?php
									 $found = FALSE;
									 $matchNutrient = "vitamin b";
									 foreach (getNutrients($foodItem) as $nutr => $amt){
										 echo "<li>" . $nutr . " (" . $amt . "% DV)</li>";
										 if (in_array(strtolower($nutr), $moodFood) && !$found) {
											 // echo "test";
						 						$matchNutrient = strtolower($nutr);
												// echo $matchNutrient;
												$found = true;
						 					}
									 }
									 // echo "match = " . $matchNutrient;
									 // echo array_search($matchNutrient, $moodFood);
									 $optimalMood = strtoupper(array_search($matchNutrient, $moodFood));
									 ?>
								 </ul>

								 <div id="ingredients-output">
									 <h3>Ingredients:</h3>
									 <div id="individual-ingredients">
										 <?php
										 foreach($foodItem["nutrition"]["ingredients"] as $ingredient){
											 echo "<h2>".$ingredient["name"]."</h2>";
										 } ?>
									 </div>
								 </div>
							 </div>
						 </div>
					 </a>
				 </div>
					 <?php
				 };
	 	 }?>


	</div>
</body>
</html>
