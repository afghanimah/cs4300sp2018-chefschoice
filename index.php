<!-- Main Page -->
<?php include('includes/init.php'); ?>

<!DOCTYPE html>

<html>
	<header>
	  <meta charset="UTF-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <link rel="stylesheet" type="text/css" href="styles/master.css" media="all"/>

	  <title>Chef's Choice</title>
	</header>

	<body>

		<form method="post" action="format.php">
			<input class="search-input" type="POST" name="input-mood"
			placeholder="Enter a Mood">

			<input class="search-input" type="POST" name="input-food" placeholder="Enter a Food">

			<input class="search-input" type="POST" name="input-nutri"
			placeholder="Enter a Nutrient">

			<input type="submit" name="submit-query">
		</form>

	</body>
</html>
