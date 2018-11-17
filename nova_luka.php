<?php
	if(isset($_POST["submit"])) {
		$ime_luke = $_POST["ime_luke"];
		$ime_mjesta = $_POST["ime_mjesta"];
		$br_pristanista = $_POST["br_pristanista"];

		if (strlen($ime_luke) > 3 && strlen($ime_mjesta) > 3 && is_numeric($br_pristanista)) {
			require_once 'connection.php';
			$sql = "INSERT INTO luka (nazivLuke, nazivMjesta, brojPristanista) VALUES ('$ime_luke', '$ime_mjesta', '$br_pristanista');";
            if (mysqli_query($conn, $sql)) {
				$ime_luke = "";
				$ime_mjesta = "";
				$br_pristanista = "";
                header("Location: luka.php");
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
					<li><a class="active" href="luka.php">Luka</a></li>
					<li><a href="pristaniste.php">Pristanište</a></li>
					<li><a href="linija.php">Linija</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="luka.php">Popis luka</a></li>
					<li><a class="active" href="nova_luka.php">Nova luka</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="ime_luke">Naziv luke</label>
						<input type="text" name="ime_luke" value="<?php echo $ime_luke; ?>">
						<label for="ime_mjesta">Naziv mjesta</label>
						<input type="text" name="ime_mjesta" value="<?php echo $ime_mjesta; ?>">
						<label for="br_pristanista">Broj pristaništa</label>
						<input type="number" name="br_pristanista" min="0" value="<?php echo $br_pristanista; ?>">
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
