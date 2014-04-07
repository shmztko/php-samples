<?php
	session_start();
?>


<?php

	if (isset($_SESSION['visit-count'])){
		$_SESSION['visit-count'] += 1;

	} else {
		$_SESSION['visit-count'] = 1;
	}

	print($_SESSION['visit-count'] . '回目の訪問です。')

?>