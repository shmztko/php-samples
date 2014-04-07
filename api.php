<?php

	date_default_timezone_set("UTC");

	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "php_test";

	try {
		$pdo = new PDO("mysql:host=".$host.";dbname=".$database."", $user, $password);


		if (isset($_POST["id"])) {
			$query = "SELECT * FROM Records WHERE played_at BETWEEN :from AND :to";

			$statement = $pdo->prepare($query);
			$statement->execute(array(':from' => '2014-01-01', ':to' => date('Y-m-d'))); 
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			print (json_encode($result));

		} else {
			echo("Invalid Parameter.");
		}



	} catch (PDOException $e) {
		echo ("Connection failed. -> ". $e->getMessage());
		die();
	}

	$pdo = null;