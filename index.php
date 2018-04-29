<!-- Main Page -->
<?php include('includes/init.php'); ?>
<!DOCTYPE html>

<html>
<header>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/master.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/form.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/ionicons.min.css" media="all"/>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Source+Sans+Pro:200" rel="stylesheet">
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/slide.js"></script>
	<title>Chef's Choice</title>
</header>
<body>

	<div id="names_topright">
		Abraham Ghanimah (afg63)
		Abrahm Magana (adm264)
		Johanna Smith-Palliser (jls628)
		Oscar Barraza (odb5)
	</div>

	<div id="chef_bottomright">
		<img src="images/chef.png" alt="Cartoon chef" />
	</div>

	<div id='contentContainer'>
		<div id='content'>
			<h1><a href="">Chef's Choice</a></h1>

			<form method="post" action="index.php" name="search-form">
				<div class="center">
					When I am
					<div class="group">
						<script>
							function autosuggest(str) {
								console.log(str);
								if (str.length == 0) {
									console.log("_blank")
									return;
								} else {
									var xmlhttp = new XMLHttpRequest();
									xmlhttp.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
											console.log(this.responseText);
										}
									};
									xmlhttp.open("GET", "phpserver.php?q=" + str, true);
									xmlhttp.send();
								}
							}
						</script>
						<input type="text" name="input-mood" id="mood" onkeyup="autosuggest(this.value)" required>
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

							<!-- <div class="group">
								<input type="text" name="input-nutrient" placeholder=""/>
								<span class="bar"></span>
								<label>[nutrient]</label>
							</div> -->

							<div class="group">
								<input type="text" name="input-exclude" placeholder=""/>
								<span class="bar"></span>
								<label>[exclude eggs, milk, ...]</label>
							</div>

							<br />

							<div id="dropdowns-container">
								<div class="custom-select">
									<select name="input-cuisine">
										<option disabled selected value>[cuisine]</option>
										<?php
										$cuisineArr = array("African", "Chinese", "Japanese", "Korean", "Vietnamese",
										"Thai", "Indian", "British", "Irish", "French", "Italian", "Mexican", "Spanish",
										"Middle Eastern", "Jewish", "American", "Cajun", "Southern", "Greek",
										"German", "Nordic", "Eastern European", "Caribbean", "Latin American");
										foreach ($cuisineArr as $cuisine) {
											echo '<option value=' . $cuisine . '> ' . $cuisine . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-diet">
										<option disabled selected value>[diet]</option>
										<?php
										$dietArr = array("Pescetarian", "Lacto vegetarian", "Ovo vegetarian", "Vegan", "Vegetarian");
										foreach ($dietArr as $diet) {
											echo '<option value=' . $diet . '> ' . $diet . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-intolerances">
										<option disabled selected value>[intolerances]</option>
										<?php
										$intolerancesArr = array("Dairy", "Egg", "Gluten", "Peanut", "Sesame",
										"Seafood", "Shellfish", "Soy", "Sulfite", "Tree nut", "Wheat");
										foreach ($intolerancesArr as $intol) {
											echo '<option value=' . $intol . '> ' . $intol . '</option>';
										}
										?>
									</select>
								</div>

								<br />

								<div class="custom-select">
									<select name="input-type">
										<option disabled selected value>[type]</option>
										<?php
										$typeArr = array("Main course", "Side", "Dessert", "Appetizer", "Salad",
										"Bread", "Breakfast", "Soup", "Beverage", "Sauce", "Drink");
										foreach ($typeArr as $type) {
											echo '<option value=' . $type . '> ' . $type . '</option>';
										}
										?>
									</select>
								</div>
							</div>


						</div>
					</div>

					<input type="submit" name="submit-query" value="Analyze"/>
				</div>

			</form>

		</div>
	</div>

	<div id="results">
		<?php include('format.php');?>
	</div>
</body>
</html>
