<?php
	require_once 'connection.php';
	$mjesta = array();
	$sql = "SELECT * FROM luka";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($mjesta, $row);
			}
		}
		mysqli_free_result($result);
	}
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
	if(isset($_POST["submit"])) {
		$sifra_luke = $_POST["sifra_luke"];
		$kapacitet_broda = $_POST["kapacitet_broda"];
		$sif_nadr_pristanista = $_POST["sif_nadr_pristanista"];
		if ($sif_nadr_prist == "") {
			$sif_nadr_prist = "NULL";
		}

		if (is_numeric($kapacitet_broda)) {
			require_once 'connection.php';
			$sql = "INSERT INTO pristaniste (sifraLuke, kapacitetBroda, sifraNadredenogPristanista) VALUES ('$sifra_luke', '$kapacitet_broda', $sif_nadr_prist);";
            if (mysqli_query($conn, $sql)) {
				$sifra_luke = "";
				$kapacitet_broda = "";
				$sif_nadr_pristanista = "";
                exit(header("Location: novo_pristaniste.php"));
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
					<li><a class="active" href="pristaniste.php">Pristanište</a></li>
					<li><a href="linija.php">Linija</a></li>
					<li><a href="karta.php">Karta</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="pristaniste.php">Popis pristaništa</a></li>
					<li><a class="active" href="novo_pristaniste.php">Novo pristanište</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="sifra_luke">Odaberite luku</label>
						<select name="sifra_luke" onchange="location=<?php echo $_SERVER['PHP_SELF']; ?>">
							<option value="">-- Odaberite mjesto --</option>
						<?php foreach ($mjesta as $key => $value) { ?>
							<option value="<?php echo $value["sifraLuke"]; ?>" <?php if ($sifra_luke == $value["sifraLuke"]) { echo "selected"; } ?>><?php echo $value["nazivLuke"] . " (" . $value["nazivMjesta"] . ")"; ?></option>
						<?php } ?>
						</select>
						<label for="kapacitet_broda">Kapacitet broda</label>
						<input type="number" min="0" name="kapacitet_broda" value="<?php echo $kapacitet_broda; ?>">
						<label for="sif_nadr_pristanista">Nadredjeno pristanište</label>
						<select name="sif_nadr_pristanista">
							<option value="">-- Odaberite pristanište --</option>
						<?php foreach ($pristanista as $key => $value) { ?>
							<?php echo $sif_nadr_prist; ?>
							<option value="<?php echo $value["sifPristanista"]; ?>" <?php if ($sif_nadr_prist == $value["sifraNadredenogPristanista"]) { echo "selected"; } ?>><?php echo $value["sifPristanista"]; ?></option>
						<?php } ?>
						</select>
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
