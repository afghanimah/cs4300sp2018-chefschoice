<?php 
	
	if ($_POST['submit-query']) {
		$food = filter_input(INPUT_POST, 'input-food', FILTER_SANITIZE_STRING);
		$mood = filter_input(INPUT_POST, 'input-mood', FILTER_SANITIZE_STRING);
		$nutrients = filter_input(INPUT_POST, 'input-nutri', FILTER_SANITIZE_STRING);
		
		echo $food . " " . $mood . " " . $nutrients;
	}

	

?>