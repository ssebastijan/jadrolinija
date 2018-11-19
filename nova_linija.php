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

	if (isset($_GET["edit"]) && isset($_GET["id"])) {
		$id = $_GET["id"];
		require_once 'connection.php';
		$linija = array();
		$sql = "SELECT * FROM linija WHERE sifraLinije = $id";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($linija, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($linija) == 1) {
			$ima_linija = true; 
		}
		$sifra_linije = $linija[0]["sifraLinije"];
		$satOdlaska = date("H:i", strtotime($linija[0]["satOdlaska"]));
		$satDolaska = date("H:i", strtotime($linija[0]["satDolaska"]));
		$dan = $linija[0]["dan"];
		$sifraOdlaznogPristanista = $linija[0]["sifraOdlaznogPristanista"];
		$sifraDolaznogPristanista = $linija[0]["sifraDolaznogPristanista"];

	} else if(isset($_POST["spremi"])) {
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
	} else if (isset($_POST["save"])) {
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
	} else if (isset($_POST["edit"])) {
		$sifra_linije = $_POST["sifraLinije"];
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
			$sql = "UPDATE linija SET satOdlaska = '$satOdlaska', satDolaska = '$satDolaska', dan = '$dan', sifraOdlaznogPristanista = '$sifraOdlaznogPristanista', sifraDolaznogPristanista = '$sifraDolaznogPristanista' WHERE sifraLinije = $sifra_linije";
			if (mysqli_query($conn, $sql)) {
				$sifra_linije = "";
				$satOdlaska = "";
				$satDolaska = "";
				$dan = "";
				$sifraOdlaznogPristanista = "";
				$sifraDolaznogPristanista = "";
                exit(header("Location: linija.php"));
            } else {
                echo '<script>alert("Dogodila se greška prilikom uredjivanja podataka u bazi!");</script>';
            }
		}
		$ima_linija = true;
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
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="linija.php">Popis linija</a></li>
						<?php if(!$ima_linija) { ?>
					<li><a class="active" href="nova_linija.php">Nova linija</a></li>
						<?php } else { ?>
					<li><a class="active" href="nova_linija.php">Uredjivanje linije</a></li>
						<?php } ?>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<?php if($ima_linija) { ?>
						<input type="hidden" name="sifraLinije" value="<?php echo $sifra_linije; ?>">
						<?php } ?>
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
						<?php if(!$ima_linija) { ?>
						<input type="submit" name="save" value="Spremi">
						<?php } else { ?>
						<input type="submit" name="edit" value="Uredi">
						<?php } ?>
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
