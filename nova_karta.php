<?php
	require_once 'connection.php';
	$putnici = array();
	$sql = "SELECT sifPutnik, CONCAT(imePutnik, ' ', prezimePutnik) as ime FROM putnik";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($putnici, $row);
			}
		}
		mysqli_free_result($result);
	}
	$linije = array();
	$sql = "SELECT sifraLinije, CONCAT(p1.nazivPristanista, ' - ', p2.nazivPristanista, ' (', dan, ' - ', satOdlaska, ' - ', satDolaska , ')') as linija from linija join pristaniste p1 on linija.sifraOdlaznogPristanista = p1.sifPristanista join pristaniste p2 on linija.sifraDolaznogPristanista = p2.sifPristanista;";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($linije, $row);
			}
		}
		mysqli_free_result($result);
	}
	$brodovi = array();
	$sql = "SELECT * FROM brod;";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($brodovi, $row);
			}
		}
		mysqli_free_result($result);
	}
	if (isset($_POST["submit"])) {
		$sifPutnika = $_POST["putnik"];
		$sifLinije = $_POST["linija"];
		$sifBroda = $_POST["brod"];

		if ($sifPutnika != "" && $sifLinije != "" && $sifBroda != "") {
			$sql = "INSERT INTO karta (sifPutnika, sifLinije, sifBroda, satPolaska) VALUES ('$sifPutnika', '$sifLinije', '$sifBroda', '$sifLinije');";
			if (mysqli_query($conn, $sql)) {
				$sifPutnika = "";
				$sifLinije = "";
				$sifBroda = "";
                exit(header("Location: nova_karta.php"));
            } else {
                echo '<script>alert("Dogodila se greška prilikom spremanja podataka u bazu!");</script>';
            }
		} else {
			echo "Nisu odabrana sva polja!!!";
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
					<li><a href="putnik.php">Putnik</a></li>
					<li><a class="active" href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="karta.php">Popis karata</a></li>
					<li><a class="active" href="nova_karta.php">Nova karta</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="putnik">Putnik</label>
						<select name="putnik">
							<option value="">-- Odaberi putnika --</option>
							<?php foreach ($putnici as $putnik) { ?>
								<option value="<?php echo $putnik["sifPutnik"]; ?>" <?php if($putnik["sifPutnik"] == $sifPutnika) { echo "selected"; } ?>><?php echo $putnik["ime"]; ?></option>
							<?php } ?>
						</select>
						<label for="linija">Linija</label>
						<select name="linija">
							<option value="">-- Odaberi liniju --</option>
							<?php foreach ($linije as $linija) { ?>
								<option value="<?php echo $linija["sifraLinije"]; ?>" <?php if($linija["sifraLinije"] == $sifLinije) { echo "selected"; } ?>><?php echo $linija["linija"]; ?></option>
							<?php } ?>
						</select>
						<label for="brod">Brod</label>
						<select name="brod">
							<option value="">-- Odaberi brod --</option>
							<?php foreach ($brodovi as $brod) { ?>
								<option value="<?php echo $brod["sifBrod"]; ?>" <?php if($brod["sifBrod"] == $sifBroda) { echo "selected"; } ?>><?php echo $brod["nazivBrod"]; ?></option>
							<?php } ?>
						</select>
						<input type="submit" name="submit" value="Spremi">
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
