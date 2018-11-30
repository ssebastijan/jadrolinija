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

	if (isset($_GET["edit"]) && isset($_GET["putnik"]) && isset($_GET["linija"]) && isset($_GET["brod"])) {
		$putnik = $_GET["putnik"];
		$linija = $_GET["linija"];
		$brod = $_GET["brod"];
		require_once 'connection.php';
		$karta = array();
		$sql = "SELECT * FROM karta WHERE sifPutnika = $putnik AND sifLinije = $linija AND sifBroda = $brod";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($karta, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($karta) > 0) {
			$ima_karta = true; 
		}
		$id = $karta[0]["id"];
		$sifPutnika = $karta[0]["sifPutnika"];
		$sifLinije = $karta[0]["sifLinije"];
		$sifBroda = $karta[0]["sifBroda"];
		
	} if (isset($_POST["save"])) {
		$sifPutnika = $_POST["putnik"];
		$sifLinije = $_POST["linija"];
		$sifBroda = $_POST["brod"];

		$errors = array();
		if (!$sifPutnika) {
			$errors[0] = "Morate odabrati putnika";
		}
		if (!$sifLinije) {
			$errors[1] = "Morate odabrati liniju";
		}
		if (!$sifBroda) {
			$errors[2] = "Morate odabrati brod";
		}

		if (count($errors) == 0) {
			$sql = "INSERT INTO karta (sifPutnika, sifLinije, sifBroda, satPolaska) VALUES ('$sifPutnika', '$sifLinije', '$sifBroda', '$sifLinije');";
			if (mysqli_query($conn, $sql)) {
				$sifPutnika = "";
				$sifLinije = "";
				$sifBroda = "";
                exit(header("Location: karta.php"));
            } else {
            	echo "<script>alert('" . mysqli_error($conn) . "');</script>";
            }
		}
	} else if (isset($_POST["edit"])) {
		$id = $_POST["id"];
		$sifPutnika = $_POST["putnik"];
		$sifLinije = $_POST["linija"];
		$sifBroda = $_POST["brod"];

		$errors = array();
		if (!$sifPutnika) {
			$errors[0] = "Morate odabrati putnika";
		}
		if (!$sifLinije) {
			$errors[1] = "Morate odabrati liniju";
		}
		if (!$sifBroda) {
			$errors[2] = "Morate odabrati brod";
		}

		if (count($errors) == 0) {
			$sql = "UPDATE karta SET sifPutnika = '$sifPutnika', sifLinije = '$sifLinije', sifBroda = '$sifBroda', satPolaska = '$sifLinije' WHERE id = $id";
			if (mysqli_query($conn, $sql)) {
				$sifPutnika = "";
				$sifLinije = "";
				$sifBroda = "";
                exit(header("Location: karta.php"));
            } else {
            	echo "<script>alert('" . mysqli_error($conn) . "');</script>";
            }
		}
		
		$ima_karta = true;
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
						<?php if($ima_karta) { ?>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<?php } ?>
						<label for="putnik">Putnik</label>
						<select class="<?php if($errors[0]) { echo "error"; } ?>" name="putnik">
							<option value="">-- Odaberi putnika --</option>
							<?php foreach ($putnici as $putnik) { ?>
								<option value="<?php echo $putnik["sifPutnik"]; ?>" <?php if($putnik["sifPutnik"] == $sifPutnika) { echo "selected"; } ?>><?php echo $putnik["ime"]; ?></option>
							<?php } ?>
						</select>
						<label for="linija">Linija</label>
						<select class="<?php if($errors[1]) { echo "error"; } ?>" name="linija">
							<option value="">-- Odaberi liniju --</option>
							<?php foreach ($linije as $linija) { ?>
								<option value="<?php echo $linija["sifraLinije"]; ?>" <?php if($linija["sifraLinije"] == $sifLinije) { echo "selected"; } ?>><?php echo $linija["linija"]; ?></option>
							<?php } ?>
						</select>
						<label for="brod">Brod</label>
						<select class="<?php if($errors[2]) { echo "error"; } ?>" name="brod">
							<option value="">-- Odaberi brod --</option>
							<?php foreach ($brodovi as $brod) { ?>
								<option value="<?php echo $brod["sifBrod"]; ?>" <?php if($brod["sifBrod"] == $sifBroda) { echo "selected"; } ?>><?php echo $brod["nazivBrod"]; ?></option>
							<?php } ?>
						</select>
						<?php if(!$ima_karta) { ?>
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
