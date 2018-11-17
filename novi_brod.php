<?php
	if(isset($_POST["submit"])) {
		$ime_broda = $_POST["ime_broda"];
		$kapacitet_broda = $_POST["kapacitet_broda"];


		if (strlen($ime_broda) > 3 && is_numeric($kapacitet_broda)) {
			require_once 'connection.php';
			$sql = "INSERT INTO brod (nazivBrod, kapacitetPutnici) VALUES ('$ime_broda', '$kapacitet_broda');";
            if (mysqli_query($conn, $sql)) {
				$ime_broda = "";
				$kapacitet_broda = "";
                header("Location: novi_brod.php");
            } else {
                echo '<script>alert("Dogodila se greška prilikom spremanja podataka u bazu!");</script>';
            }
		} else {
			echo '<script>alert("Nisu sva polja ispravno popunjena!");</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Jadrolinija</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="top">
			<nav>
				<ul>
					<li><a href="index.php">Index</a></li>
					<li><a href="luka.php">Luka</a></li>
					<li><a href="pristaniste.php">Pristanište</a></li>
					<li><a href="linija.php">Linija</a></li>
					<li><a class="active" href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="brod.php">Popis brodova</a></li>
					<li><a class="active" href="novi_brod.php">Novi brod</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="ime_broda">Naziv broda</label>
						<input type="text" name="ime_broda" value="<?php echo $ime_broda; ?>">
						<label for="kapacitet_broda">Kapacitet broda</label>
						<input type="number" name="kapacitet_broda" value="<?php echo $kapacitet_broda; ?>">
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
