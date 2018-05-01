<!-- Submits queries to Spoonacular API and displays results -->
<?php
	require_once "vendor/autoload.php";
	include ('src/SpoonacularAPIClient.php');
	include ("includes/apikey.php");

	$mfJSON = `python3 scripts/main.py`;
	$moodFood = json_decode($mfJSON, true);

	use SpoonacularAPILib\SpoonacularAPIClient;
	// Configuration parameters
	$xMashapeKey = $API_KEY; // The Mashape application you want to use for this session.
	$client = new SpoonacularAPIClient($xMashapeKey);

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
		$m = $moodFood[$moodInput];
		if ($moodFood[$moodInput] == 'vitamin b6') {
			$m = 'vitamin+b';
		} else if ($moodFood[$moodInput] == 'vitamin d'){
			$m = 'vitamin+d';
		}

		if ($first){
			$getURL .= "query=" . $foodInput . "+" . $m;
			$first = false;
		} else {
			$getURL .= "&query=" . $foodInput . "+" . $m;
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

		//look for happy tostada or happy food? (tostada is example)
		//in the case of just the mood, we can hard code it
		$foodURL_mood = $getRequestLink . "/recipes/search?" . "query=" . $foodInput . "+" . $m;
		$foodResponse_mood = Unirest\Request::get(
			$foodURL_mood,
			  $clientArray);
		$parsedFoodResp_mood = json_decode(json_encode($foodResponse_mood->body), JSON_PRETTY_PRINT);
		$foodSearchItem_mood = getFoodByID($parsedFoodResp_mood["results"][0]["id"], $clientArray);

		function getNutrients($foodItem){
			global $moodInput;
			global $moodFood;

			$nutrientAmounts = array();
			foreach($foodItem["nutrition"]["nutrients"] as $nutrientArr) {
				if ($nutrientArr["title"] !== "Calories"){
					$nutrientAmounts[$nutrientArr["title"]] = $nutrientArr["percentOfDailyNeeds"];
				}
			}
			arsort($nutrientAmounts);
			$topNut = array_slice($nutrientAmounts, 0, 5, true); //Change later to be more like thesaurus
			array_push($topNut, $nutrients[$moodFood[strtolower($moodInput)]]);
			return $topNut;
		}

		function getNutrients_all($foodItem){
			$nutrientAmounts = array();
			foreach($foodItem["nutrition"]["nutrients"] as $nutrientArr) {
				if ($nutrientArr["title"] !== "Calories"){
					$nutrientAmounts[$nutrientArr["title"]] = $nutrientArr["percentOfDailyNeeds"];
				}
			}

			arsort($nutrientAmounts);

			return $nutrientAmounts;
		}

		$user = getNutrients_all($foodSearchItem);
		$ours = getNutrients_all($foodSearchItem_mood);

		$m_to_nutrient = [
			"magnesium" => "Magnesium",
			"fat" => "Fat",
			"carbohydrates" => "Carbohydrates",
			"manganese" => "Manganese",
			"vitamin+d" => "Vitamin D",
			"vitamin+b" => "Vitamin B6"
		];
		$denom = $ours[$m_to_nutrient[$m]];
		if ($denom == 0) {
			$denom = 0.01;
		}
		$score = min(array(round($user[$m_to_nutrient[$m]] / $denom, 2), 1));
		$rating = NULL;
		($score >= 0.6) ? $rating = "good" : $rating = "bad";
	} else {
		unset($_SESSION["mood"]);
		unset($_SESSION["food"]);
	}
?>
