<html>
<head>
<title>Hit & Blow!!</title>
</head>
<?php
	if (isset($_GET['message'])) {
		print $_GET['message'];
	}
?>
<form action="./hitblowcheck.php" method="POST">
<input type="text" name="user_input" value=""/>

<input type="submit" value="Hit & Blow!!!"/> 
</form>
</html>