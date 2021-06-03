<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');

		if(isset($_POST['movie'])){
			$name = $_POST['movie'];
			$sql = "insert into movies (name) values (:mn)";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mn' => $name));
		}
		else if(isset($_POST['series'])){
			$name = $_POST['series'];
			$sql = "insert into series (name) values (:sn)";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':sn' => $name));
		}

		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>