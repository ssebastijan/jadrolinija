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
	if (isset($_GET["edit"]) && isset($_GET["id"])) {
		$id = $_GET["id"];
		require_once 'connection.php';
		$pristaniste = array();
		$sql = "SELECT * FROM pristaniste WHERE sifPristanista = $id";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($pristaniste, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($pristaniste) == 1) {
			$ima_pristanista = true; 
		}
		$sif_pristanista = $pristaniste[0]["sifPristanista"];
		$sifra_luke = $pristaniste[0]["sifraLuke"];
		$naziv_pristanista = $pristaniste[0]["nazivPristanista"];
		$kapacitet_broda = $pristaniste[0]["kapacitetBroda"];
		$sif_nadr_prist = $pristaniste[0]["sifraNadredenogPristanista"];


		$pristanista = array();
		$sql = "SELECT * FROM pristaniste WHERE sifraLuke = $sifra_luke";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($pristanista, $row);
				}
			}
			mysqli_free_result($result);
		}

	} else if(isset($_POST["save"])) {
		$sifra_luke = $_POST["sifra_luke"];
		$kapacitet_broda = $_POST["kapacitet_broda"];
		$naziv_pristanista = $_POST["naziv_pristanista"];
		$sif_nadr_pristanista = $_POST["sif_nadr_pristanista"];
		if ($sif_nadr_pristanista == "") {
			$sif_nadr_pristanista = "NULL";
		}
		$errors = array();
		if (!$sifra_luke) {
			$errors[0] = "Odaberite luku";
		}
		if (strlen($naziv_pristanista) < 3) {
			$errors[1] = "Prekratko ime";
		}
		if (!is_numeric($kapacitet_broda)) {
			$errors[2] = "Morate unijeti broj";
		}

		if (count($errors) == 0) {
			$start = microtime(TRUE) - time();
			$sql = "SELECT sifraLuke, brojPristanista FROM luka WHERE sifraLuke = $sifra_luke";
			if ($result = mysqli_query($conn, $sql)) {
				if (mysqli_num_rows($result)) {
					while($row = mysqli_fetch_assoc($result)) {
						$maxBrPrist = $row["brojPristanista"];
					}
				}
				mysqli_free_result($result);
			}
			$sql = "select count(sifraLuke) as cnt from pristaniste where sifraLuke = $sifra_luke";
			if ($result = mysqli_query($conn, $sql)) {
				if (mysqli_num_rows($result)) {
					while($row = mysqli_fetch_assoc($result)) {
						$brPrist = $row["cnt"];
					}
				}
				mysqli_free_result($result);
			}

			if ($brPrist < $maxBrPrist) {
				require_once 'connection.php';
				$sql = "INSERT INTO pristaniste (sifraLuke, kapacitetBroda, nazivPristanista, sifraNadredenogPristanista) VALUES ('$sifra_luke', '$kapacitet_broda', '$naziv_pristanista', $sif_nadr_pristanista);";
	            if (mysqli_query($conn, $sql)) {
					$sifra_luke = "";
					$kapacitet_broda = "";
					$sif_nadr_pristanista = "";
					$stop = microtime(TRUE) - time();
					$time = $stop - $start;
					echo "<script>if(!alert('{$time}')){window.location.reload();}</script>";
	                exit(header("Location: novo_pristaniste.php"));
	            } else {
	                echo '<script>alert("Dogodila se greška prilikom spremanja podataka u bazu!");</script>';
	            }
	        } else {
	        	echo '<script>alert("Popunjena su sva mjesta u luci!");</script>';
	        }
		}
	} else if(isset($_POST["edit"])) {
		$sif_pristanista = $_POST["sif_pristanista"];
		$sifra_luke = $_POST["sifra_luke"];
		$kapacitet_broda = $_POST["kapacitet_broda"];
		$naziv_pristanista = $_POST["naziv_pristanista"];
		$sif_nadr_prist = $_POST["sif_nadr_pristanista"];
		if ($sif_nadr_prist == "") {
			$sif_nadr_prist = "NULL";
		}

		if (is_numeric($kapacitet_broda) && strlen($naziv_pristanista) > 2 && $kapacitet_broda > 0 && $sif_nadr_prist > 0) {


			$sql = "SELECT sifraLuke, brojPristanista FROM luka WHERE sifraLuke = $sifra_luke";
			if ($result = mysqli_query($conn, $sql)) {
				if (mysqli_num_rows($result)) {
					while($row = mysqli_fetch_assoc($result)) {
						$maxBrPrist = $row["brojPristanista"];
					}
				}
				mysqli_free_result($result);
			}
			$sql = "select count(sifraLuke) as cnt from pristaniste where sifraLuke = $sifra_luke";
			if ($result = mysqli_query($conn, $sql)) {
				if (mysqli_num_rows($result)) {
					while($row = mysqli_fetch_assoc($result)) {
						$brPrist = $row["cnt"];
					}
				}
				mysqli_free_result($result);
			}
			require_once 'connection.php';
			$sql = "UPDATE pristaniste SET sifraLuke = '$sifra_luke', kapacitetBroda = '$kapacitet_broda', nazivPristanista = '$naziv_pristanista', sifraNadredenogPristanista = $sif_nadr_prist WHERE sifPristanista = $sif_pristanista";
            if (mysqli_query($conn, $sql)) {
            	$sif_pristanista = "";
            	$sifra_luke = "";
				$kapacitet_broda = "";
				$naziv_pristanista = "";
				$sif_nadr_prist = "";
                exit(header("Location: pristaniste.php"));
            } else {
                echo '<script>alert("Dogodila se greška prilikom uredjivanja podataka u bazi!");</script>';
            }
		} else {
			echo '<script>alert("Nisu sva polja ispravno popunjena!");</script>';
		}

		$pristanista = array();
		$sql = "SELECT * FROM pristaniste WHERE sifraLuke = $sifra_luke";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($pristanista, $row);
				}
			}
			mysqli_free_result($result);
		}
		$ima_pristanista = true;
	} else if (isset($_POST["sifra_luke"])) {
		$sifra_luke = $_POST["sifra_luke"];
		$pristanista = array();
		$sql = "SELECT * FROM pristaniste WHERE sifraLuke = $sifra_luke";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($pristanista, $row);
				}
			}
			mysqli_free_result($result);
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
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a href="pristaniste.php">Popis pristaništa</a></li>
						<?php if(!$ima_pristanista) { ?>
					<li><a class="active" href="novo_pristaniste.php">Novo pristanište</a></li>
						<?php } else { ?>
					<li><a class="active" href="novo_pristaniste.php">Uredjivanje pristaništa</a></li>
						<?php } ?>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<?php if($ima_pristanista) { ?>
						<input type="hidden" name="sif_pristanista" value="<?php echo $sif_pristanista; ?>">
						<?php } ?>
						<label for="sifra_luke">Odaberite luku</label>
						<select class="<?php if($errors[0]) { echo "error"; } ?>" name="sifra_luke" onchange="this.form.submit()">
							<option value="">-- Odaberite mjesto --</option>
						<?php foreach ($mjesta as $key => $value) { ?>
							<option value="<?php echo $value["sifraLuke"]; ?>" <?php if ($sifra_luke == $value["sifraLuke"]) { echo "selected"; } ?>><?php echo $value["nazivLuke"] . " (" . $value["nazivMjesta"] . ")"; ?></option>
						<?php } ?>
						</select>
						<label for="naziv_pristanista">Naziv pristaništa</label>
						<input class="<?php if($errors[1]) { echo "error"; } ?>" type="text" min="0" name="naziv_pristanista" value="<?php echo $naziv_pristanista; ?>">
						<label for="kapacitet_broda">Kapacitet broda</label>
						<input class="<?php if($errors[2]) { echo "error"; } ?>" type="number" min="0" name="kapacitet_broda" value="<?php echo $kapacitet_broda; ?>">
						<label for="sif_nadr_pristanista">Nadredjeno pristanište</label>
						<select name="sif_nadr_pristanista">
							<option value="">-- Odaberite pristanište --</option>
						<?php foreach ($pristanista as $key => $value) { ?>
							<option value="<?php echo $value["sifPristanista"]; ?>" 
								<?php if ($sif_nadr_prist == $value["sifPristanista"]) { 
									echo "selected"; 
								} ?>>
								<?php echo $value["nazivPristanista"]; ?></option>
						<?php } ?>
						</select>
						<?php if(!$ima_pristanista) { ?>
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
