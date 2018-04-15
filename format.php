<!-- Submits queries to Spoonacular API -->

<?php
	require_once "vendor/autoload.php";
	include ('src/SpoonacularAPIClient.php');
	use SpoonacularAPILib\SpoonacularAPIClient;

	// Configuration parameters
	$xMashapeKey = getenv("API_KEY"); // The Mashape application you want to use for this session.
	$client = new SpoonacularAPIClient($xMashapeKey);

	// $ppl = new SpoonacularAPIClient("Johanna");
	$client = $client->getClient();


	if ($_POST['submit-query']) {
		$food = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$mood = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
		$nutrients = filter_input(INPUT_POST, 'input-nutri', FILTER_SANITIZE_STRING);

		// echo shell_exec('python scripts/search.py '.$food.' '.$mood.' '.$nutrients);


		// Query the API
		$query = $nutrients;
		$cuisine = 'italian';
		$diet = 'vegetarian';
		$excludeIngredients = 'coconut';
		$intolerances = 'egg, gluten';
		$limitLicense = false;
		$number = 20;
		$offset = 0;
		$type = 'main course';
		// key-value map for optional query parameters
		$queryParams = array('key' => 'value');

		$results = json_decode(json_encode($client->searchRecipes($query)), true);


		foreach ($results["results"] as $result => $data) {
			echo $data["title"];
		}

	}

	



?>
