<?php

	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "php_test";

	$pdo = new PDO("mysql:host=".$host.";dbname=".$database, $user, $password);

	if (isset($_GET["pd"]) && isset($_GET["id"]) && isset($_GET["name"])) {		

		execute($_GET["pd"], $_GET["id"], $_GET["name"]);

	} else {
		print("Invalid Paramter.");
		die();
	}


	function execute($process, $id, $name) {
		if ($process == "U") {
			udpate($id, $name);

		} else if ($process == "C") {
			insert($id, $name);

		} else {
			print ("NOOP");
			die();
		}
	}


	function udpate($id, $name) {
		global $pdo;

		print "UPDATE前のデータ一覧<br/>";
		foreach(select_all() as $row) {
			print_row($row);
		}

		print "******************<br/>";
		
		$update_query = "UPDATE items SET name = ? WHERE id = ?";
		$statement = $pdo->prepare($update_query);

		$is_succeeded = $statement->execute(array($name, $id));
		if ($is_succeeded) {
			print("UPDATE 処理成功<br/>");
		} else {
			print_r($statement->errorInfo());
			print("UPDATE 処理失敗 <br/>");
		}


		print "UPDATE後のデータ一覧<br/>";
		foreach(select_all() as $row) {
			print_row($row);
		}
	}


	function insert($id, $name) {
		global $pdo;

		print "INSERT前のデータ一覧<br/>";
		foreach(select_all() as $row) {
			print_row($row);
		}

		print "******************<br/>";
		
		$insert_query = "INSERT INTO items(id, name) VALUES(?, ?);";
		$statement = $pdo->prepare($insert_query);

		$is_succeeded = $statement->execute(array($id, $name));
		if ($is_succeeded) {
			print("INSERT 処理成功<br/>");
		} else {
			print_r($statement->errorInfo());
			print("INSERT 処理失敗 <br/>");
		}


		print "INSERT後のデータ一覧<br/>";
		foreach(select_all() as $row) {
			print_row($row);
		}
	}

	function select_all() {
		global $pdo;
		return $pdo->query("SELECT * FROM items");
	}

	function print_row($row) {
		print($row["id"].",".$row["name"]."<br/>");
	}