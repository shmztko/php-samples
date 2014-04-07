<?php
require_once("UploadException.php");


function execute_upload() {
	if ($_FILES["selected_file"]["error"] === UPLOAD_ERR_OK) {
		$upload_dir = "./";
		$upload_file = mb_convert_encoding($upload_dir . basename($_FILES["selected_file"]["name"]), "SJIS");

		echo("<pre>");

		if (move_uploaded_file($_FILES["selected_file"]["tmp_name"], $upload_file)) {
			echo("File is valid, and was successfully uploaded.\n");
		} else {
			echo("Possible file upload attack!!");
		}

		echo("Here is some more debugging info:");
		print_r($_FILES);

		echo("</pre>");
	} else {
		print_r($_FILES);
		throw new UploadException($_FILES["selected_file"]);
	}
}

try {
	execute_upload();

} catch (UploadException $e) {
	echo($e->getMessage());
}