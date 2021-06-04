<?php
	session_start();
	if(isset($_SESSION['user'])){
		require_once('pdo.php');
		$vals = "";
		if(isset($_POST['download'])){
			$vals = $_POST['download'];
		}
		else{
			$vals = str_replace('-', '', $_POST['default']);
		}
		if(strpos($vals, 'movie') !== false){
			$id = str_replace('movie', '', $vals);
			$sql = "select isDownloaded from movies where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mid' => $id));
			$isDownloaded = $stmt -> fetch(PDO::FETCH_ASSOC);
			$isDownloaded = !$isDownloaded['isDownloaded'];

			$sql = "update movies set isDownloaded=:mdown where id=:mid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':mdown' => (int)$isDownloaded, ':mid' => $id));
		}
		else if(strpos($vals, 'srs') !== false){
			$id = str_replace('srs', '', $vals);
			$sql = "select isDownloaded from series where id=:sid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':sid' => $id));
			$isDownloaded = $stmt -> fetch(PDO::FETCH_ASSOC);
			$isDownloaded = !$isDownloaded['isDownloaded'];

			$sql = "update series set isDownloaded=:sdown where id=:sid";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute(array(':sdown' => (int)$isDownloaded, ':sid' => $id));
		}

		header("Location: watch.php");
		return;
	}
	else{
		header("Location: index.php");
		return;
	}
?>
