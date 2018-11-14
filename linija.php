<!DOCTYPE html>
<html>
	<head>
		<title>Jadrolinija</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.php">Index</a></li>
				<li><a href="luka.php">Luka</a></li>
				<li><a href="pristaniste.php">Pristanište</a></li>
				<li><a class="active" href="linija.php">Linija</a></li>
				<li><a href="karta.php">Karta</a></li>
				<li><a href="brod.php">Brod</a></li>
				<li><a href="putnik.php">Putnik</a></li>
			</ul>
		</nav>
		<section>
			<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
				<input type="submit" name="submit" value="Spremi">
			</form>
		</section>
	</body>
</html>
