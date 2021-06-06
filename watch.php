<?php
	session_start();
	require_once('cdns.php');
	require_once('pdo.php');
	$user = "";
	if(!isset($_SESSION['user']))
	{
		header("Location: index.php");
		return;
	}
	$user = $_SESSION['user'];
	$sql = "select * from movies";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute();
	$movies = $stmt -> fetchAll(PDO::FETCH_ASSOC);

	$sql = "select * from series";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute();
	$series = $stmt -> fetchAll(PDO::FETCH_ASSOC);


?>

<html>
<head>
	<title>Binging</title>
	<link rel="icon" type="image/icon" href="./images/titleLogo.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

	<nav class="navbar navbar-dark navbar-expand-sm fixed-top">
		<div class="nav navbar-nav mr-auto">
			<i class="nav-item nav-link h4">Welcome <?= ucfirst($user) ?> !!</i>
		</div>
		<div class="nav navbar-nav ml-auto">
			<a href="logout.php" class="nav-item nav-link h6">Logout</a>
		</div>
	</nav>

	<main class="container main">
		<div class="row">
			<div class="col-12">
				<ul class="nav nav-tabs nav-justified" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="movies-tab" data-toggle="tab" href="#movies" role="tab" aria-controls="movies" aria-selected="true">Movies</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="series-tab" data-toggle="tab" href="#series" role="tab" aria-controls="series" aria-selected="false">Series</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">

					<!-- Movies Pane Start -->
					<div class="tab-pane fade show active" id="movies" role="tabpanel" aria-labelledby="movies-tab">
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 mt-5">
									<form method="POST" action="add.php">
										<div class="input-group row justify-content-center">
											<input type="text" name="movie" class="form-control col-8 col-md-7" placeholder="Add Movies" required>
											<button type="submit" class="form-control btn btn-dark col-2 col-md-1">Add</button>
										</div>
									</form>
								</div>
							</div>
							<hr>
							<div class="row mb-5">
								<div class="col-12">
									<table class="table table-hover">
										<thead class="thead-dark">
											<tr class="row">
												<th class="col-5 col-md-7">Name</th>
												<th class="col-3 col-md-2 text-center">Downld</th>
												<th class="col-3 col-md-2 text-center">Watched</th>
												<th class="col-1"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($movies as $movie){
													if(!$movie['isWatched']){
														$id = "movie".$movie['id'];
														echo('<tr class="row">
															<td class="col-5 col-md-7">'.htmlentities($movie["name"]).'</td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="downloaded.php">
																	<div class="form-check">
																		<input type="checkbox" name="download" value='.$id.' class="form-check-input" '.($movie["isDownloaded"]?'checked="checked"':"").' onclick="this.form.submit()">
																		<input type="checkbox" name="default" value="-'.$id.'" class="form-check-input d-none" checked>
																	</div>
																</form>
															</td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="watched.php">
																	<div class="form-check">
																		<input type="checkbox" name="watch" value='.$id.' class="form-check-input" onclick="if(this.checked){this.form.submit()}">
																	</div>
																</form>
															</td>
															<td class="col-1">
																<form method="POST" action="delete.php">
																	<button type="submit" class="close" aria-label="Delete" name="delete" value='.$id.'>
																		<span aria-hidden="true">&times;</span>
																	</button>
																</form>
															</td>
														</tr>');
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<hr>
							<div class="row">
								<h3 class="col-12">Watched</h3>
							</div>
							<div class="row">
								<div class="col-12">
									<table class="table table-hover">
										<thead class="thead-dark">
											<tr class="row">
												<th class="col-8 col-md-9">Name</th>
												<th class="col-3 col-md-2 text-center">Rewatch</th>
												<th class="col-1"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($movies as $movie) {
													if($movie['isWatched']){
														$id = "movie".$movie['id'];
														echo('<tr class="row">
															<td class="col-8 col-md-9"><s>'.htmlentities($movie["name"]).'</s></td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="watched.php">
																	<div class="form-check">
																		<input type="checkbox" name="watch" value='.$id.' class="form-check-input" onclick="if(this.checked){this.form.submit()}">
																	</div>
																</form>
															</td>
															<td class="col-1">
																<form method="POST" action="delete.php">
																	<button type="submit" class="close" aria-label="Delete" name="delete" value='.$id.'>
																		<span aria-hidden="true">&times;</span>
																	</button>
																</form>
															</td>
														</tr>');
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- Movies Pane End -->

					<!-- Series Pane Start -->
					<div class="tab-pane fade" id="series" role="tabpanel" aria-labelledby="series-tab">
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 mt-5">
									<form method="POST" action="add.php">
										<div class="input-group row justify-content-center">
											<input type="text" name="series" class="form-control col-8 col-md-7" placeholder="Add Series" required>
											<button type="submit" class="form-control btn btn-dark col-2 col-md-1">Add</button>
										</div>
									</form>
								</div>
							</div>
							<hr>
							<div class="row mb-5">
								<div class="col-12">
									<table class="table table-hover">
										<thead class="thead-dark">
											<tr class="row">
												<th class="col-5 col-md-7">Name</th>
												<th class="col-3 col-md-2 text-center">Downld</th>
												<th class="col-3 col-md-2 text-center">Watched</th>
												<th class="col-1"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($series as $srs){
													if(!$srs['isWatched']){
														$id = "srs".$srs['id'];
														echo('<tr class="row">
															<td class="col-5 col-md-7">'.htmlentities($srs["name"]).'</td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="downloaded.php">
																	<div class="form-check">
																		<input type="checkbox" name="download" '.($srs["isDownloaded"]?'checked="checked"':"").' value='.$id.' class="form-check-input" onclick="this.form.submit()">
																		<input type="checkbox" name="default" value="-'.$id.'" class="form-check-input d-none" checked>
																	</div>
																</form>
															</td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="watched.php">
																	<div class="form-check">
																		<input type="checkbox" name="watch" value='.$id.' class="form-check-input" onclick="if(this.checked){this.form.submit()}">
																	</div>
																</form>
															</td>
															<td class="col-1">
																<form method="POST" action="delete.php">
																	<button type="submit" class="close" aria-label="Delete" name="delete" value='.$id.'>
																		<span aria-hidden="true">&times;</span>
																	</button>
																</form>
															</td>
														</tr>');
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<hr>
							<div class="row">
								<h3 class="col-12">Watched</h3>
							</div>
							<div class="row">
								<div class="col-12">
									<table class="table table-hover">
										<thead class="thead-dark">
											<tr class="row">
												<th class="col-8 col-md-9">Name</th>
												<th class="col-3 col-md-2 text-center">Rewatch</th>
												<th class="col-1"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($series as $srs) {
													if($srs['isWatched']){
														$id = "srs".$srs['id'];
														echo('<tr class="row">
															<td class="col-8 col-md-9"><s>'.htmlentities($srs["name"]).'</s></td>
															<td class="col-3 col-md-2 text-center">
																<form method="POST" action="watched.php">
																	<div class="form-check">
																		<input type="checkbox" name="watch" value='.$id.' class="form-check-input" onclick="if(this.checked){this.form.submit()}">
																	</div>
																</form>
															</td>
															<td class="col-1">
																<form method="POST" action="delete.php">
																	<button type="submit" class="close" aria-label="Delete" name="delete" value='.$id.'>
																		<span aria-hidden="true">&times;</span>
																	</button>
																</form>
															</td>
														</tr>');
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- Series Pane End -->

				</div>
			</div>
		</div>
	</main>

</body>
</html>