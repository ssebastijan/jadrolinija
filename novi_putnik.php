<?php
	function validacijaPutovnice($brPutovnice)
	{
		return 0;
	}

	function validacijaImena($ime)
	{
		if (strlen($ime) >= 3) {
			return 0;
		}
		return 1;
	}

	if (isset($_GET["edit"]) && isset($_GET["id"])) { 
		$id = $_GET["id"];
		require_once 'connection.php';
		$putnik = array();
		$sql = "SELECT * FROM putnik WHERE sifPutnik = $id";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($putnik, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($putnik) == 1) {
			$ima_putnika = true;
		}
		$sifra_putnika = $putnik[0]["sifPutnik"];
		$ime_putnika = $putnik[0]["imePutnik"];
		$prezime_putnika = $putnik[0]["prezimePutnik"];
		$broj_putovnice = $putnik[0]["brojPutovnice"];
		$drzavljanstvo = $putnik[0]["drzavljanstvo"];

	} else if(isset($_POST["save"])) {
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
	} else if(isset($_POST["edit"])) {
		$sifra_putnika = $_POST["sifra_putnika"];
		$ime_putnika = $_POST["ime_putnika"];
		$prezime_putnika = $_POST["prezime_putnika"];
		$broj_putovnice = $_POST["broj_putovnice"];
		$drzavljanstvo = $_POST["drzavljanstvo"];
		if (!validacijaPutovnice($broj_putovnice) && !validacijaImena($ime_putnika) && !validacijaImena($prezime_putnika)) {
			require_once 'connection.php';
			$sql = "UPDATE putnik SET imePutnik = '$ime_putnika', prezimePutnik = '$prezime_putnika', brojPutovnice = '$broj_putovnice', drzavljanstvo = '$drzavljanstvo' WHERE sifPutnik = $sifra_putnika";
            if (mysqli_query($conn, $sql)) {
            	$sifra_putnika = "";
				$ime_putnika = "";
				$prezime_putnika = "";
				$broj_putovnice = "";
				$drzavljanstvo = "";
                header("Location: putnik.php");
            } else {
                echo '<script>alert("Dogodila se greška prilikom uredjivanja podataka u bazi!");</script>';
            }
		} else {
			echo '<script>alert("Nije sve validirano!");</script>';
		}
		$ima_putnika = true;
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
					<?php if(!$ima_putnika) { ?>
					<li><a class="active" href="novi_putnik.php">Novi putnik</a></li>
					<?php } else { ?>
					<li><a class="active" href="novi_putnik.php">Uredjivanje putnika</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<?php if($ima_putnika) { ?>
						<input type="hidden" name="sifra_putnika" value="<?php echo $sifra_putnika; ?>">
						<?php } ?>
						<label for="ime_putnika">Ime</label>
						<input type="text" name="ime_putnika" value="<?php echo $ime_putnika; ?>">
						<label for="prezime_putnika">Prezime</label>
						<input type="text" name="prezime_putnika" value="<?php echo $prezime_putnika; ?>">
						<label for="broj_putovnice">Broj putovnice</label>
						<input type="text" name="broj_putovnice" value="<?php echo $broj_putovnice; ?>">
						<label for="drzavljanstvo">Državljanstvo</label>
						<input type="text" name="drzavljanstvo" value="<?php echo $drzavljanstvo; ?>">
						<?php if(!$ima_putnika) { ?>
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
