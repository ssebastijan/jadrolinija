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
	if (isset($_POST["mjesto"])) {
		$odabrano = true;
		$odabranoMjesto = $_POST["mjesto"];
		require_once 'connection.php';
		$pristanista = array();
		$sql = "select p1.sifPristanista, p1.sifraLuke, p1.nazivPristanista, p1.kapacitetBroda, p2.nazivPristanista as nazivNadredjenogPristanista from pristaniste p1 left join pristaniste p2 on p1.sifraNadredenogPristanista = p2.sifPristanista WHERE p1.sifraLuke = '$odabranoMjesto' order by p1.sifPristanista";
		if ($result = mysqli_query($conn, $sql)) {
			if (mysqli_num_rows($result)) {
				while($row = mysqli_fetch_assoc($result)) {
					array_push($pristanista, $row);
				}
			}
			mysqli_free_result($result);
		}
	}

	if (isset($_GET["delete"]) && isset($_GET["id"])) {
		if ($_GET["delete"] == true) {
			$id = $_GET["id"];
			require_once 'connection.php';
			$sql = "DELETE FROM pristaniste WHERE sifPristanista = $id";
            if (mysqli_query($conn, $sql)) {
                echo '<script> 
                	alert("Pristanište uspješno obrisano"); 
                	window.location.href = "' . $_SERVER["PHP_SELF"] . '"; 
                </script>';
                header("Location: " . $_SERVER["PHP_SELF"]);
            } else {
            	$err = $conn->error;
                echo '<script> 
                	alert("' . $err . '"); 
                	window.location.href = "' . $_SERVER["PHP_SELF"] . '"; 
                </script>';
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
					<li><a class="active" href="pristaniste.php">Popis pristaništa</a></li>
					<li><a href="novo_pristaniste.php">Novo pristanište</a></li>
				</ul>
			</div>
			<div class="right">
				<?php if (count($mjesta) === 0) { ?>
					<h3 style="padding-left: 20px;">Nema nijednog mjesta</h3>
				<?php } else { ?>
				<section>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<label for="ime_luke">Odaberite luku</label>
						<select name="mjesto" onchange="this.form.submit()">
							<option value="">-- Odaberite mjesto --</option>
						<?php foreach ($mjesta as $key => $value) { ?>
							<option value="<?php echo $value["sifraLuke"]; ?>" <?php if ($odabranoMjesto == $value["sifraLuke"]) { echo "selected"; } ?>><?php echo $value["nazivLuke"] . " (" . $value["nazivMjesta"] . ")"; ?></option>
						<?php } ?>
						</select>
						<?php if($odabrano == true) { ?>
							<?php if(count($pristanista) > 0) { ?>
							<table class="table">
								<thead>
									<tr>
										<td>Sifra pristanista</td>
										<td>Naziv pristaništa</td>
										<td>Kapacitet broda</td>
										<td>Nadredjeno pristanište</td>
										<td>Akcija</td>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($pristanista as $pristaniste) { ?>
									<tr>
										<td><?php echo $pristaniste["sifPristanista"]; ?></td>
										<td><?php echo $pristaniste["nazivPristanista"]; ?></td>
										<td><?php echo $pristaniste["kapacitetBroda"]; ?></td>
										<td><?php echo $pristaniste["nazivNadredjenogPristanista"]; ?></td>
										<td><button type="button" onclick="brisi(<?php echo $pristaniste["sifPristanista"]; ?>);  return false;">Obriši</button></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php } else { ?>
								<h3>U odabranoj luci nema nijednog pristaništa</h3>
							<?php } ?>
						<?php } ?>
					</form>
				</section>
				<?php }?>
			</div>
		</div>
	</body>
	<script>
		function brisi(id) {
			var cfrm = confirm("Jeste li sigurni da želite obrisati?");
			if (cfrm == true) {
				window.location.href = "<?php echo $_SERVER["PHP_SELF"] . "?delete=true&id="; ?>" + id;
			}
		}
	</script>
</html>
