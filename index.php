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

	<title>Chef's Choice</title>
</header>
<body>

	<div id='contentContainer'>
		<div id='content'>
			<h1>Chef's Choice</h1>

			<form method="post" action="index.php">
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
				</div>

				<input type="submit" name="submit" id="submit-butt"/>

			</form>

		</div>
	</div>
	<div id="results">
		<?php include('format.php');?>

	</div>


</body>
</html>
