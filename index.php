<!-- Main Page -->
<?php include('includes/init.php'); ?>

<!DOCTYPE html>

<html>
<header>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/master.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/form.css" media="all"/>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Source+Sans+Pro:200" rel="stylesheet">
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/slide.js"></script>

	<title>Chef's Choice</title>
</header>
<body>

	<div id='contentContainer'>
		<div id='content'>
			<h1>Chef's Choice</h1>

			<form method="post" action="index.php" name="search-form">
				<div class="center">
					When I am
					<div class="group">
						<input type="text" name="input-mood" required>
						<span class="bar"></span>
						<label>[mood]</label>
					</div>,
					<br />
					I eat
					<div class="group">
						<input type="text" name="input-food" required>
						<span class="bar"></span>
						<label>[food]</label>
					</div>.

					<div id="advanced-search">
						<div id="adv-panel">Advanced Search</div>
						<div id="slide">

							<input type="text" name="input-nutrient" placeholder="Nutrient"/>

							<br />

							<select name="input-cuisine">
								<option disabled selected value> Select Cuisine </option>
								<?php
								$cuisineArr = array("African", "Chinese", "Japanese", "Korean", "Vietnamese",
								"Thai", "Indian", "British", "Irish", "French", "Italian", "Mexican", "Spanish",
								"Middle Eastern", "Jewish", "American", "Cajun", "Southern", "Greek",
								"German", "Nordic", "Eastern European", "Caribbean", "Latin American");
								foreach ($cuisineArr as $cuisine) {
									echo '<option value=\"' . $cuisine . '\"> ' . $cuisine . '</option>';
								}
								?>
							</select>

							<br />

							<select name="input-diet">
								<option disabled selected value> Select Diet </option>
								<?php
								$dietArr = array("Pescetarian", "Lacto vegetarian", "Ovo vegetarian", "Vegan", "Vegetarian");
								foreach ($dietArr as $diet) {
									echo '<option value=\"' . $diet . '\"> ' . $diet . '</option>';
								}
								?>
							</select>

							<input type="text" name="input-exclude" placeholder="Exclude..."/>

							<select name="input-intolerances">
								<option disabled selected value>Select Intolerances</option>
								<?php
								$intolerancesArr = array("Dairy", "Egg", "Gluten", "Peanut", "Sesame",
								"Seafood", "Shellfish", "Soy", "Sulfite", "Tree nut", "Wheat");
								foreach ($intolerancesArr as $intol) {
									echo '<option value=\"' . $intol . '\"> ' . $intol . '</option>';
								}
								?>
							</select>

							<br />

							<select name="input-type">
								<option disabled selected value> Select Type </option>
								<?php
								$typeArr = array("Main course", "Side", "Dessert", "Appetizer", "Salad",
								"Bread", "Breakfast", "Soup", "Beverage", "Sauce", "Drink");
								foreach ($typeArr as $type) {
									echo '<option value=\"' . $type . '\"> ' . $type . '</option>';
								}
								?>
							</select>

						</div>
					</div>

					<input type="submit" name="submit-query" value="go"/>
				</div>

			</form>

		</div>
	</div>


	<div id="results">
		<?php include('format.php');?>

	</div>


</body>
</html>
