<?php include('includes/init.php'); ?>

<!DOCTYPE html>

<html>
	<header>
		
	</header>

	<body>

		<form method="post" action="format.php">
			<input class="search-input" type="POST" name="input-food" placeholder="Enter a Food">
			<input class="search-input" type="POST" name="input-mood"
			placeholder="Enter a Mood">
			<input class="search-input" type="POST" name="input-nutri"
			placeholder="Enter a Nutrient">

			<input type="submit" name="submit-query">
		</form>

	</body>
</html>

