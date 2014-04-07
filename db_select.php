<?php
	date_default_timezone_set("UTC");
	
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "php_test";

	try {
		$pdo = new PDO("mysql:host=".$host.";dbname=".$database."", $user, $password);

		// $query = "SELECT * FROM  Records";

		// foreach ($pdo->query($query) as $row) {
		// 	print($row["id"].",".$row["played_at"]."<br/>");
		// }

		// print("**************************************<br/>");


		// $query2 = "SELECT * FROM Records WHERE played_at BETWEEN '2014-01-01' AND '2014-03-31'";

		// $query2 = "SELECT * FROM Records WHERE played_at BETWEEN ? AND ?";
		$query2 = "SELECT * FROM Records WHERE played_at BETWEEN :from AND :to";

		$statement = $pdo->prepare($query2);
		// $statement->execute(array('2014-01-01', '2014-03-31')); 
		$statement->execute(array(':from' => '2014-01-01', ':to' => date('Y-m-d'))); 
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		print (json_encode($result));

		// while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		// 	print($row["id"].",".$row["played_at"]."<br/>");
		// }



		// foreach (as $row) {
		// 	print($row["id"].",".$row["played_at"]."<br/>");
		// }

		// // やってることはforeach文のやつと同じ
		// $stmt = $pdo->query($query);
		// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// 	print($row["id"].",".$row["played_at"]."<br/>");
		// }

	} catch (PDOException $e) {
		echo ("Connection failed. -> ". $e->getMessage());
		die();
	}

	$pdo = null;