<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');
		if(strpos($_POST['watch'], 'movie') !== false){
			$id = str_replace('movie', '', $_POST['watch']);
			$sql = "select isWatched from movies where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mid' => $id));
			$isWatched = $stmt -> fetch(PDO::FETCH_ASSOC);
			$isWatched = !$isWatched['isWatched'];

			$sql = "update movies set isWatched=:mwatch where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mwatch' => (int)$isWatched, ':mid' => $id));
		}
		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>