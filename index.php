<!-- Main Page -->
<?php include('includes/init.php'); ?>

<!DOCTYPE html>

<html>
	<header>
	  <meta charset="UTF-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <link rel="stylesheet" type="text/css" href="styles/master.css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Source+Sans+Pro:200" rel="stylesheet">
		<script src="https://d3js.org/d3.v5.min.js"></script>

	  <title>Chef's Choice</title>
	</header>
	<body>
		<div>

		</div>
		<div id='contentContainer'>
			<div id='content'>
				<h1>Chef's Choice</h1>
				<form method="post" action="index.php">
					<input class="search-input" type="POST" name="input-mood"
					placeholder="Enter a Mood">

					<input class="search-input" type="POST" name="input-food" placeholder="Enter a Food">

					<input class="search-input" type="POST" name="input-nutri"
					placeholder="Enter a Nutrient">

					<input type="submit" name="submit-query">
				</form>
			</div>
		</div>
		<div id="results">
			<?php include('format.php');?>

		</div>

		
	</body>
</html>
