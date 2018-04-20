<!-- Submits queries to Spoonacular API -->

<?php
	require_once "vendor/autoload.php";
	include ('src/SpoonacularAPIClient.php');
	use SpoonacularAPILib\SpoonacularAPIClient;


	$APIkey = "***REMOVED***";
	// Configuration parameters
	// Instructions: replace getenv("API_KEY") with the api key for local testing and change back for public
	$xMashapeKey = $APIkey; // The Mashape application you want to use for this session.
	$client = new SpoonacularAPIClient($xMashapeKey);

	// $ppl = new SpoonacularAPIClient("Johanna");
	$client = $client->getClient();


	if ($_POST['submit-query']) {
		$food = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$mood = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
		$query = filter_input(INPUT_POST, 'input-nutri', FILTER_SANITIZE_STRING);


		//standard link for unirest request
		$getRequestLink = "https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/search?";

		// These code snippets use an open-source library. http://unirest.io/php
		$response = Unirest\Request::get($getRequestLink."query=".$query,
			  array(
			    "X-Mashape-Key" => $APIkey,
			    "Accept" => "application/json"
			  ));

		//encodes unirest object to json for iteration purposes
 		$parsedResponse = json_decode(json_encode($response->body), true);

		//displays results from query
		foreach($parsedResponse["results"] as $item) {
			echo $item["title"]."<br>";
		};
	}
?>
