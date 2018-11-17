<?php
	require_once 'connection.php';
	$pristanista = array();
	$sql = "SELECT * FROM pristaniste";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($pristanista, $row);
			}
		}
		mysqli_free_result($result);
	}
	if (isset($_POST["submit"])) {
		$satOdlaska = $_POST["satOdlaska"];
		$satDolaska = $_POST["satDolaska"];
		$dan = $_POST["dan"];
		$sifraOdlaznogPristanista = $_POST["sifraOdlaznogPristanista"];
		$sifraDolaznogPristanista = $_POST["sifraDolaznogPristanista"];

		$errors = array();

		if (DateTime::createFromFormat('H:i', $satOdlaska) !== FALSE) {
		} else {
			$errors[0] = "Neispravno upisano vrijeme";
		}

		if (DateTime::createFromFormat('H:i', $satDolaska) !== FALSE) {
		} else {
			$errors[1] = "Neispravno upisano vrijeme";
		}

		if ($sifraOdlaznogPristanista == $sifraDolaznogPristanista) {
			$errors[2] = "Odlazno i dolazno pristanište moraju biti različiti";
			$errors[3] = "Odlazno i dolazno pristanište moraju biti različiti";
		} else {
			if (!$sifraOdlaznogPristanista) {
				$errors[2] = "Morate odabrati odlazno polazište";
			}
			if (!$sifraDolaznogPristanista) {
				$errors[3] = "Morate odabrati dolazno polazište";
			}
		}

		if (count($errors) == 0) {
			require_once 'connection.php';
			$sql = "INSERT INTO linija (satOdlaska, satDolaska, dan, sifraOdlaznogPristanista, sifraDolaznogPristanista) VALUES ('$satOdlaska', '$satDolaska', '$dan', '$sifraOdlaznogPristanista', '$sifraDolaznogPristanista')";
			if (mysqli_query($conn, $sql)) {
				$satOdlaska = "";
				$satDolaska = "";
				$dan = "";
				$sifraOdlaznogPristanista = "";
				$sifraDolaznogPristanista = "";
                exit(header("Location: nova_linija.php"));
            } else {
                echo '<script>alert("Dogodila se greška prilikom spremanja podataka u bazu!");</script>';
            }
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
					<li><a class="active" href="linija.php">Linija</a></li>
					<li><a href="karta.php">Karta</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="linija.php">Popis linija</a></li>
					<li><a class="active" href="nova_linija.php">Nova linija</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="satOdlaska">Sat odlaska</label>
						<input class="<?php if($errors[0]) { echo "error"; } ?>" type="datetime" name="satOdlaska" placeholder="hh:mm" value="<?php echo $satOdlaska; ?>">
						<label for="satDolaska">Sat dolaska</label>
						<input class="<?php if($errors[1]) { echo "error"; } ?>" type="datetime" name="satDolaska" placeholder="hh:mm" value="<?php echo $satDolaska; ?>">
						<label for="dan">Dan</label>
						<select name="dan">
							<option value="Ponedjeljak" <?php if($dan == "Ponedjeljak") { echo "selected"; } ?>>Ponedjeljak</option>
							<option value="Utorak" <?php if($dan == "Utorak") { echo "selected"; } ?>>Utorak</option>
							<option value="Srijeda" <?php if($dan == "Srijeda") { echo "selected"; } ?>>Srijeda</option>
							<option value="Četvrtak" <?php if($dan == "Četvrtak") { echo "selected"; } ?>>Četvrtak</option>
							<option value="Petak" <?php if($dan == "Petak") { echo "selected"; } ?>>Petak</option>
							<option value="Subota" <?php if($dan == "Subota") { echo "selected"; } ?>>Subota</option>
							<option value="Nedjelja" <?php if($dan == "Nedjelja") { echo "selected"; } ?>>Nedjelja</option>
						</select>
						<label for="sifraOdlaznogPristanista">Odlazno pristanište</label>
						<select class="<?php if($errors[2]) { echo "error"; } ?>" name="sifraOdlaznogPristanista">
							<option value="0">-- Odaberite pristanište --</option>
							<?php foreach ($pristanista as $pristaniste) { ?>
								<option value="<?php echo $pristaniste["sifPristanista"]; ?>" <?php if($sifraOdlaznogPristanista == $pristaniste["sifPristanista"]) { echo "selected"; } ?>><?php echo $pristaniste["nazivPristanista"]; ?></option>
							<?php } ?>
						</select>
						<label for="sifraDolaznogPristanista">Dolazno pristanište</label>
						<select class="<?php if($errors[3]) { echo "error"; } ?>" name="sifraDolaznogPristanista">
							<option value="0">-- Odaberite pristanište --</option>
							<?php foreach ($pristanista as $pristaniste) { ?>
								<option value="<?php echo $pristaniste["sifPristanista"]; ?>" <?php if($sifraDolaznogPristanista == $pristaniste["sifPristanista"]) { echo "selected"; } ?>><?php echo $pristaniste["nazivPristanista"]; ?></option>
							<?php } ?>
						</select>
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
