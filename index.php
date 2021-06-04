<?php
	require_once('cdns.php');
	session_start();
	if(isset($_SESSION['user']))
	{
		header("Location: watch.php");
		return;
	}
	require_once('pdo.php');
	$error = "";
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$sql = "select * from users where username=:user";
		$stmt = $pdo -> prepare($sql);
		$stmt -> execute(array(':user' => $_POST['username']));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			$salt = 'XyZzy12*_';
			$stored_hash = hash('md5',$salt.$_POST['password']);
			if($stored_hash == $row['password'])
			{
				$_SESSION['user'] = $row['username'];
				header("Location: watch.php");
				return;
			}
		}
		$_SESSION['error'] = "Invalid credentials";
		header("Location: index.php");
		return;
	}
?>

<html>
	<head>
		<title>Binging</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>

		<main class="container my-5">
			<div class="row justify-content-center">
				<div class="card col-10 col-lg-5">
					<div class="card-header row">
						<h4>
							Login
						</h4>
					</div>
					<div class="card-body">
						<?php
							$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
							if($error){
								echo'<span class="alert alert-danger" role="alert">'.$error.'</span>';
							}
							unset($_SESSION['error']);
						?>
						<form method="POST" class="mt-3">
							<div class="form-group row">
								<label class="form-label col-12 col-lg-3">
									Username:
								</label>
								<input type="text" name="username" class="col-12 col-lg-9 form-control" required />
							</div>
							<div class="form-group row">
								<label class="form-label col-12 col-lg-3">
									Password:
								</label>
								<input type="password" name="password" class="col-12 col-lg-9 form-control" required />
							</div>
							<div class="form-group row">
								<button type="submit" class="form-control btn btn-primary col-4 col-md-3 ml-auto">Submit</button>
								<button type="reset" class="form-control btn btn-secondary col-4 col-md-3 ml-1">Cancel</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</main>

	</body>
</html>