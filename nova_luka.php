<?php
	if (isset($_GET["edit"]) && isset($_GET["id"])) {
		$id = $_GET["id"];
		require_once 'connection.php';
		$luka = array();
		$sql = "SELECT * FROM luka WHERE sifraLuke = $id";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($luka, $row);
				}
			}
			mysqli_free_result($result);
		}
		if (count($luka) == 1) {
			$ima_luka = true; 
		}
		$sifra_luke = $luka[0]["sifraLuke"];
		$ime_luke = $luka[0]["nazivLuke"];
		$ime_mjesta = $luka[0]["nazivMjesta"];
		$br_pristanista = $luka[0]["brojPristanista"];

	} else if(isset($_POST["spremi"])) {
		$ime_luke = $_POST["ime_luke"];
		$ime_mjesta = $_POST["ime_mjesta"];
		$br_pristanista = $_POST["br_pristanista"];

		$errors = array();
		if (strlen($ime_luke) < 3) {
			$errors[0] = "Ime luke mora imati više od 3 slova";
		}
		if (strlen($ime_mjesta) < 3) {
			$errors[1] = "Ime mjesta mora imati više od 3 slova";
		}
		if (!is_numeric($br_pristanista)) {
			$errors[2] = "Morate unijeti cijeli broj";
		}

		if (count($errors) == 0) {
			require_once 'connection.php';
			$sql = "INSERT INTO luka (nazivLuke, nazivMjesta, brojPristanista) VALUES ('$ime_luke', '$ime_mjesta', '$br_pristanista');";
            if (mysqli_query($conn, $sql)) {
				$ime_luke = "";
				$ime_mjesta = "";
				$br_pristanista = "";
                header("Location: luka.php");
            } else {
            	echo "<script>alert('" . mysqli_error($conn) . "');</script>";
            }
		}
	} else if(isset($_POST["uredi"])) {
		$sifra_luke = $_POST["sifra_luke"];
		$ime_luke = $_POST["ime_luke"];
		$ime_mjesta = $_POST["ime_mjesta"];
		$br_pristanista = $_POST["br_pristanista"];

		$errors = array();
		if (strlen($ime_luke) < 3) {
			$errors[0] = "Ime luke mora imati više od 3 slova";
		}
		if (strlen($ime_mjesta) < 3) {
			$errors[1] = "Ime mjesta mora imati više od 3 slova";
		}
		if (!is_numeric($br_pristanista)) {
			$errors[2] = "Morate unijeti cijeli broj";
		}

		if (count($errors) == 0) {
			require_once 'connection.php';
			$sql = "UPDATE luka set nazivLuke = '$ime_luke', nazivMjesta = '$ime_mjesta', brojPristanista = '$br_pristanista' WHERE sifraLuke = $sifra_luke";
            if (mysqli_query($conn, $sql)) {
				$ime_luke = "";
				$ime_mjesta = "";
				$br_pristanista = "";
                header("Location: luka.php");
            } else {
            	echo "<script>alert('" . mysqli_error($conn) . "');</script>";
            }
		}
		$ima_luka = true; 
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
						<?php if (!$ima_luka) { ?>
					<li><a class="active" href="nova_luka.php">Nova luka</a></li>
						<?php } else { ?>
					<li><a class="active" href="nova_luka.php">Uredjivanje luke</a></li>
						<?php } ?>
				</ul>
			</div>
			<div class="right">
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<?php if ($ima_luka) { ?>
						<input type="hidden" name="sifra_luke" value="<?php echo $sifra_luke; ?>">
						<?php } ?>
						<label for="ime_luke">Naziv luke</label>
						<input class="<?php if($errors[0]) { echo "error"; } ?>" type="text" name="ime_luke" value="<?php echo $ime_luke; ?>">
						<label for="ime_mjesta">Naziv mjesta</label>
						<input class="<?php if($errors[1]) { echo "error"; } ?>" type="text" name="ime_mjesta" value="<?php echo $ime_mjesta; ?>">
						<label for="br_pristanista">Broj pristaništa</label>
						<input class="<?php if($errors[2]) { echo "error"; } ?>" type="number" name="br_pristanista" min="0" value="<?php echo $br_pristanista; ?>">
						<?php if ($ima_luka) { ?>
						<input type="submit" name="uredi" value="Uredi">
						<?php } else { ?>
						<input type="submit" name="spremi" value="Spremi">
						<?php } ?>
					</form>
				</section>
			</div>
		</div>
	</body>
</html>
