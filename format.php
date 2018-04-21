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

		$i = 0;
		//displays results from query
		foreach($parsedResponse["results"] as $item) {
			$i+=1;
			echo $i." ".$item["title"]."<br>";
		};
	}
?>
