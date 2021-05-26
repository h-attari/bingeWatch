<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');

		$name = $_POST['movie'];
		$sql = "insert into movies (name) values (:mn)";
		$stmt = $pdo -> prepare($sql);
		$stmt -> execute(array(':mn' => $name));

		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>