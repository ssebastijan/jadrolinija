<?php
	function validacijaPutovnice($brPutovnice)
	{
		return 0;
	}

	function validacijaImena($ime)
	{
		if (strlen($ime) > 3) {
			return 0;
		}
		return 1;
	}
	if(isset($_POST["submit"])) {
		$ime_putnika = $_POST["ime_putnika"];
		$prezime_putnika = $_POST["prezime_putnika"];
		$broj_putovnice = $_POST["broj_putovnice"];
		$drzavljanstvo = $_POST["drzavljanstvo"];

		if (!validacijaPutovnice($broj_putovnice) && !validacijaImena($ime_putnika) && !validacijaImena($prezime_putnika)) {
			require_once 'connection.php';
			$sql = "INSERT INTO putnik (imePutnik, prezimePutnik, brojPutovnice, drzavljanstvo) VALUES ('$ime_putnika', '$prezime_putnika', '$broj_putovnice', '$drzavljanstvo');";
            if (mysqli_query($conn, $sql)) {
				$ime_putnika = "";
				$prezime_putnika = "";
				$broj_putovnice = "";
				$drzavljanstvo = "";
                header("Location: novi_putnik.php");
            } else {
                echo '<script>alert("Dogodila se greška prilikom spremanja podataka u bazu!");</script>';
            }
		} else {
			echo '<script>alert("Nije sve validirano!");</script>';
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
					<li><a href="brod.php">Brod</a></li>
					<li><a class="active" href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="putnik.php">Popis putnika</a></li>
					<li><a class="active" href="novi_putnik.php">Novi putnik</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="ime_putnika">Ime</label>
						<input type="text" name="ime_putnika" value="<?php echo $ime_putnika; ?>">
						<label for="prezime_putnika">Prezime</label>
						<input type="text" name="prezime_putnika" value="<?php echo $prezime_putnika; ?>">
						<label for="broj_putovnice">Broj putovnice</label>
						<input type="text" name="broj_putovnice" value="<?php echo $broj_putovnice; ?>">
						<label for="drzavljanstvo">Državljanstvo</label>
						<input type="text" name="drzavljanstvo" value="<?php echo $drzavljanstvo; ?>">
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
