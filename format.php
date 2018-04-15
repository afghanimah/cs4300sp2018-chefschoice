<!-- Submits queries to Spoonacular API -->

<?php
	require_once "../vendor/autoload.php";
	include ('../src/SpoonacularAPIClient.php');
	use SpoonacularAPILib\SpoonacularAPIClient;

	// Configuration parameters
	$xMashapeKey = "xk1HGDFa1NmshAMfSgYD3ZI6PKUyp1TpWnUjsnHdp9TkMEv0Gg"; // The Mashape application you want to use for this session.
	$client = new SpoonacularAPIClient($xMashapeKey);

	// $ppl = new SpoonacularAPIClient("Johanna");
	$client = $client->getClient();


	if ($_POST['submit-query']) {
		$food = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$mood = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
		$nutrients = filter_input(INPUT_POST, 'input-nutri', FILTER_SANITIZE_STRING);

		echo shell_exec('python scripts/search.py '.$food.' '.$mood.' '.$nutrients);
	}

	$result = $client->searchRecipes($query, $cuisine, $diet, $excludeIngredients, $intolerances, $limitLicense, $number, $offset, $type, $queryParams);



?>
