<!-- Submits queries to Spoonacular API and displays results -->
<?php
	require_once "vendor/autoload.php";
	include ('src/SpoonacularAPIClient.php');
	include ("includes/apikey.php");


	use SpoonacularAPILib\SpoonacularAPIClient;
	// Configuration parameters
	$xMashapeKey = $API_KEY; // The Mashape application you want to use for this session.
	$client = new SpoonacularAPIClient($xMashapeKey);


	// $ppl = new SpoonacularAPIClient("Johanna");
	$client = $client->getClient();
	$clientArray = array("X-Mashape-Key" => $API_KEY,"Accept" => "application/json");


	if ($_POST['submit-query']) {
		$foodInput = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$moodInput = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
    $nutrientInput = filter_input(INPUT_POST, 'input-nutrient', FILTER_SANITIZE_STRING);
		$cuisineInput = filter_input(INPUT_POST, 'input-cuisine', FILTER_SANITIZE_STRING);
		$dietInput = filter_input(INPUT_POST, 'input-diet', FILTER_SANITIZE_STRING);
		$excludeInput = filter_input(INPUT_POST, 'input-exclude', FILTER_SANITIZE_STRING);
		$intolerancesInput = filter_input(INPUT_POST, 'input-intolerances', FILTER_SANITIZE_STRING);
		$typeInput = filter_input(INPUT_POST, 'input-type', FILTER_SANITIZE_STRING);

		function getFoodByID($id, $clientArray) {
			$response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/".$id."/information?includeNutrition=true", $clientArray);
			return json_decode(json_encode($response->body), true);
		};

		//standard link for unirest request
		$getRequestLink = "https://spoonacular-recipe-food-nutrition-v1.p.mashape.com";

		// concatenate GET URL
		// https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/search?cuisine=test&diet=test&excludeIngredients=test&instructionsRequired=false&intolerances=test&number=10&query=burger&type=test
		$first = true;

		$getURL = $getRequestLink . "/recipes/search?";
		if ($cuisineInput != ''){
			if ($first){
				$getURL .= "cuisine=" . $cuisineInput;
				$first = false;
			} else {
				$getURL .= "&cuisine=" . $cuisineInput;
			}
		}

		if ($dietInput != ''){
			if ($first){
				$getURL .= "diet=" . $dietInput;
				$first = false;
			} else {
				$getURL .= "&diet=" . $dietInput;
			}
		}

		if ($excludeInput != ''){
			if ($first){
				$getURL .= "excludeIngredients=" . $excludeInput;
				$first = false;
			} else {
				$getURL .= "&excludeIngredients=" . $excludeInput;
			}
		}

		if ($intolerancesInput != ''){
			if ($first){
				$getURL .= "intolerances=" . $intolerancesInput;
				$first = false;
			} else {
				$getURL .= "&intolerances=" . $intolerancesInput;
			}
		}

		// always need to limit to 10
		if ($first){
			$getURL .= "number=" . "10";
			$first = false;
		} else {
			$getURL .= "&number=" . "10";
		}

		// query required
		// AB!!!! CHANGE FOOD INPUT HERE
		if ($first){
			$getURL .= "query=" . $foodInput;
			$first = false;
		} else {
			$getURL .= "&query=" . $foodInput;
		}

		if ($typeInput != ''){
			if ($first){
				$getURL .= "type=" . $typeInput;
				$first = false;
			} else {
				$getURL .= "&type=" . $typeInput;
			}
		}

		// These code snippets use an open-source library. http://unirest.io/php
		$response = Unirest\Request::get(
			$getURL,
			  $clientArray);

		//encodes unirest object to json for iteration purposes
		$parsedResponse = json_decode(json_encode($response->body), true);

		// get results for food input
		$foodURL = $getRequestLink . "/recipes/search?" . "query=" . $foodInput;
		$foodResponse = Unirest\Request::get(
			$foodURL,
			  $clientArray);
		$parsedFoodResp = json_decode(json_encode($foodResponse->body), JSON_PRETTY_PRINT);
		$foodSearchItem = getFoodByID($parsedFoodResp["results"][0]["id"], $clientArray);

		$nutrientAmounts = array();
		foreach($foodSearchItem["nutrition"]["nutrients"] as $nutrientArr) {
			if ($nutrientArr["title"] !== "Calories"){
				$nutrientAmounts[$nutrientArr["title"]] = $nutrientArr["percentOfDailyNeeds"];
			}
		}
		arsort($nutrientAmounts);
		$topNut = array_slice($nutrientAmounts, 0, 7, true);	// change this later to something like thesaurus.com

		 $score = 0.2;
		 $rating = NULL;
		 ($score >= 0.6) ? $rating = "good" : $rating = "bad";
		 $optimalMood = "HAPPY";
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
						.text("<?php echo $foodInput; ?> is a")
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
						foreach ($topNut as $nutr => $amt){
							echo "<li>" . $nutr . " (" . $amt . "% DV)</li>";
						}
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
						.style("alignment-baseline", "middle")
						.style("text-anchor", "middle")
							.attr("font-family", "Source Sans Pro")
							.attr("font-size", "70px")
							.attr("fill", "black")
							.attr("word-wrap", "break-word");
						userFoodOptimalMoodSVG.append("text")
						.attr("x", userFoodRatingHeight/2)
						.attr("y", userFoodRatingWidth/3 - 15)
						.text("<?php echo $foodInput; ?> is best when")
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
		foreach($parsedResponse["results"] as $item) {?>
			<div class="resultsCard">
				<?php
				$imageExtension = explode(".", $item["image"]);
				?>
				<div class="resultsImage">
					<img src=<?php echo "https://webknox.com/recipeImages/".$item["id"]."-556x370.".$imageExtension[1]?> alt="results image">
				</div>
				<div class="resultsInfo">
					<div class="resultsText">
						<div id="tabs">
							<!-- <ul>
								<li><a href="#"><h2>NUTRIENTS</h2></a></li>
								<li><a href="#"><h2> -->
						</div>
						<?php $foodItem = getFoodByID($item["id"], $clientArray);?>
						<h1><?php echo $item["title"]?></h1>
						<ul>
							<li><span class="icon ion-thumbsup"></span><?php echo "Likes: ".$foodItem["aggregateLikes"]?></span></li>
							<li><span class="icon ion-trophy"></span><?php echo "Score: ".$foodItem["spoonacularScore"]?></span></li>
							<li><span class="icon ion-heart"></span><?php echo "Health Score: ".$foodItem["healthScore"]?></span></li>
						</ul>
						<h3 id="ingredients-heading">Ingredients:</h3>
						<?php foreach($foodItem["nutrition"]["ingredients"] as $ingredient){
							echo "<h2>".$ingredient["name"]."</h2>";
						} ?>


					</div>
				</div>
			</div>
			<?php
		};
	}
?>
