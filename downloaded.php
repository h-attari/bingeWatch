<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');
		if(strpos($_POST['download'], 'movie') !== false){
			$id = str_replace('movie', '', $_POST['download']);
			$sql = "select isDownloaded from movies where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mid' => $id));
			$isDownloaded = $stmt -> fetch(PDO::FETCH_ASSOC);
			$isDownloaded = !$isDownloaded['isDownloaded'];

			$sql = "update movies set isDownloaded=:mdown where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mdown' => (int)$isDownloaded, ':mid' => $id));
		}
		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>