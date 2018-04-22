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


	if ($_POST['submit-query']) {
		$foodInput = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$moodInput = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
    $nutrientsInput = filter_input(INPUT_POST, 'input-nutrient', FILTER_SANITIZE_STRING);
    $restrictionsInput = filter_input(INPUT_POST, 'input-restriction', FILTER_SANITIZE_STRING);
    // $cuisinesInput = $_POST["input-cuisine"];


		//standard link for unirest request
		$getRequestLink = "https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/search?";

		// These code snippets use an open-source library. http://unirest.io/php
		$response = Unirest\Request::get(
			$getRequestLink."query=".$foodInput."&number=".$number,
			  array(
			    "X-Mashape-Key" => $API_KEY,
			    "Accept" => "application/json"
			  ));

		//encodes unirest object to json for iteration purposes
		 $parsedResponse = json_decode(json_encode($response->body), true);

		//  Variable for the comparison score
		 $score = 0.7;
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
					</script>
				<div id="userFoodNutrientsContainer">
					<h2>Nutrients in <span id="foodInput"><?php echo $foodInput;?></span> Include: </h2>
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
						.style("fill", "white");
					</script>
			</div>

		<?php
		//displays results from query
		foreach($parsedResponse["results"] as $item) {
			echo $i." ".$item["title"]."<br>";
		};
	}
?>
