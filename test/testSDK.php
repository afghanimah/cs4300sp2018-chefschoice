<?php

require_once "../vendor/autoload.php";

include ('../src/SpoonacularAPIClient.php');

use SpoonacularAPILib\SpoonacularAPIClient;

// Configuration parameters
$xMashapeKey = "***REMOVED***"; // The Mashape application you want to use for this session.
$client = new SpoonacularAPIClient($xMashapeKey);

// $ppl = new SpoonacularAPIClient("Johanna");
$client = $client->getClient();


// Query the API
$query = 'burger';
$cuisine = 'italian';
$diet = 'vegetarian';
$excludeIngredients = 'coconut';
$intolerances = 'egg, gluten';
$limitLicense = false;
$number = 10;
$offset = 0;
$type = 'main course';
// key-value map for optional query parameters
$queryParams = array('key' => 'value');


$result = $client->searchRecipes($query, $cuisine, $diet, $excludeIngredients, $intolerances, $limitLicense, $number, $offset, $type, $queryParams);

echo "<br />";
var_dump($result);


?>
