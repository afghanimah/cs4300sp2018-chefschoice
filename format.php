<!-- Submits queries to Spoonacular API and displays results -->
<?php
	require_once "vendor/autoload.php";
	include ('src/SpoonacularAPIClient.php');
	use SpoonacularAPILib\SpoonacularAPIClient;


	$APIkey = "xk1HGDFa1NmshAMfSgYD3ZI6PKUyp1TpWnUjsnHdp9TkMEv0Gg";
	// Number of results to return from query [0-100]
	$number = 100;
	// Instructions: replace getenv("API_KEY") with the api key for local testing and change back for public
	$xMashapeKey = $APIkey;
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
			    "X-Mashape-Key" => $APIkey,
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
