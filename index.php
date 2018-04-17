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
		<div id='contentContainer'>
			<div id='content'>
				<h1>Chef's Choice</h1>
				<form method="post" action="format.php">
					<input class="search-input" type="POST" name="input-mood"
					placeholder="Enter a Mood">

					<input class="search-input" type="POST" name="input-food" placeholder="Enter a Food">

					<input class="search-input" type="POST" name="input-nutri"
					placeholder="Enter a Nutrient">

					<input type="submit" name="submit-query">
				</form>
			</div>
	</div>

		<div id="projectInfo">
			<p><b>Chef's Choice</b></p>
			<p>Abraham Ghanimah (afg63)</p>
			<p>Abrahm Magaña (adm264)</p>
			<p>Oscar Barazza (odb5)</p>
			<p>Johanna Smith-Palliser (jls628)</p>
		</div>
	</body>
</html>
