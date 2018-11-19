<?php
	if (isset($_GET["edit"]) && isset($_GET["id"])) {
		$id = $_GET["id"];
		require_once 'connection.php';
		$brod = array();
		$sql = "SELECT * FROM brod WHERE sifBrod = $id";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($brod, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($brod) == 1) {
			$ima_brod = true; 
		}
		$sifra_broda = $brod[0]["sifBrod"];
		$ime_broda = $brod[0]["nazivBrod"];
		$kapacitet_broda = $brod[0]["kapacitetPutnici"];
	} else if(isset($_POST["save"])) {
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
	} else if(isset($_POST["edit"])) { 
		$sifra_broda = $_POST["sifra_broda"];
		$ime_broda = $_POST["ime_broda"];
		$kapacitet_broda = $_POST["kapacitet_broda"];

		if (strlen($ime_broda) > 3 && is_numeric($kapacitet_broda)) {
			require_once 'connection.php';
			$sql = "UPDATE brod set nazivBrod = '$ime_broda', kapacitetPutnici = '$kapacitet_broda' WHERE sifBrod = $sifra_broda";
            if (mysqli_query($conn, $sql)) {
            	$sifra_broda = "";
				$ime_broda = "";
				$kapacitet_broda = "";
                header("Location: brod.php");
            } else {
                echo '<script>alert("Dogodila se greška prilikom uredjivanja podataka u bazi!");</script>';
            }
		} else {
			echo '<script>alert("Nisu sva polja ispravno popunjena!");</script>';
		}

		$ima_brod = true;
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
						<?php if($ima_brod) { ?>
						<input type="hidden" name="sifra_broda" value="<?php echo $sifra_broda; ?>">
						<?php } ?>
						<label for="ime_broda">Naziv broda</label>
						<input type="text" name="ime_broda" value="<?php echo $ime_broda; ?>">
						<label for="kapacitet_broda">Kapacitet broda</label>
						<input type="number" name="kapacitet_broda" value="<?php echo $kapacitet_broda; ?>">
						<?php if(!$ima_brod) { ?>
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
