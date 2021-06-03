<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');
		echo $_POST['download']."\n";
		if(strpos($_POST['download'], 'movie') !== false){
			echo $_POST['download']."\n";
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
		else if(strpos($_POST['download'], 'srs') !== false){
			$id = str_replace('srs', '', $_POST['download']);
			$sql = "select isDownloaded from series where id=:sid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':sid' => $id));
			$isDownloaded = $stmt -> fetch(PDO::FETCH_ASSOC);
			$isDownloaded = !$isDownloaded['isDownloaded'];

			$sql = "update series set isDownloaded=:sdown where id=:sid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':sdown' => (int)$isDownloaded, ':sid' => $id));
		}

		// header("Location: watch.php");
		// return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>