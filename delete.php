<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');
		if(strpos($_POST['delete'], 'movie') !== false){
			$id = str_replace('movie', '', $_POST['delete']);
			$sql = "DELETE from movies where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mid' => $id));
		}
		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>