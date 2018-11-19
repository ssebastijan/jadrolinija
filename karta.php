<?php
	require_once 'connection.php';
	$karte = array();
	$sql = "SELECT sifPutnika, sifLinije, sifBroda, CONCAT(imePutnik, ' ', prezimePutnik) as ime, CONCAT(p1.nazivPristanista, ' - ', p2.nazivPristanista) as linija, brod.nazivBrod as brod, datKarte, CONCAT(linija.dan, ' - ', linija.satOdlaska) as odlazak FROM putnik JOIN karta ON karta.sifPutnika = putnik.sifPutnik JOIN linija on karta.sifLinije = linija.sifraLinije JOIN pristaniste p1 on linija.sifraOdlaznogPristanista = p1.sifPristanista JOIN pristaniste p2 ON linija.sifraDolaznogPristanista = p2.sifPristanista JOIN brod on brod.sifBrod = karta.sifBroda;";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($karte, $row);
			}
		}
		mysqli_free_result($result);
	}

	if (isset($_GET["delete"]) && isset($_GET["putnik"]) && isset($_GET["linija"]) && isset($_GET["brod"])) {
		if ($_GET["delete"] == true) {
			$putnik = $_GET["putnik"];
			$linija = $_GET["linija"];
			$brod = $_GET["brod"];

			require_once 'connection.php';
			$sql = "DELETE FROM karta WHERE sifPutnika = $putnik AND sifLinije = $linija AND sifBroda = $brod";
			if (mysqli_query($conn, $sql)) {
                echo '<script> 
               		alert("Karta uspješno obrisana"); 
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
					<li><a class="active" href="karta.php">Popis karata</a></li>
					<li><a href="nova_karta.php">Nova karta</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<?php if (count($karte) === 0) { ?>
						<h3 style="padding-left: 20px;">Nema nijedne upisane karte</h3>
					<?php } else { ?>
					<section>
						<table class="table">
							<thead>
								<tr>
									<td>Putnik</td>
									<td>Linija</td>
									<td>Brod</td>
									<td>Datum karte</td>
									<td>Vrijeme polaska</td>
									<td>Akcija</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($karte as $karta) { ?>
								<tr>
									<td><?php echo $karta["ime"]; ?></td>
									<td><?php echo $karta["linija"]; ?></td>
									<td><?php echo $karta["brod"]; ?></td>
									<td><?php echo $karta["datKarte"]; ?></td>
									<td><?php echo $karta["odlazak"]; ?></td>
									<td>
										<button type="button" onclick="brisi(<?php echo $karta["sifPutnika"]; ?>, <?php echo $karta["sifLinije"]; ?>, <?php echo $karta["sifBroda"]; ?>);  return false;">Obriši</button>
										<button onclick="uredi(<?php echo $karta["sifPutnika"]; ?>, <?php echo $karta["sifLinije"]; ?>, <?php echo $karta["sifBroda"]; ?>)">Uredi</button></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</section>
					<?php }?>
				</section>
			</div>
		</div>
	</body>
	<script>
		function brisi(putnik, linija, brod) {
			var cfrm = confirm("Jeste li sigurni da želite obrisati?");
			if (cfrm == true) {
				window.location.href = "<?php echo $_SERVER["PHP_SELF"] . "?delete=true&putnik="; ?>" + putnik + "&linija=" + linija + "&brod=" + brod;
			}
		}
		function uredi(putnik, linija, brod) {
			window.location.href = "<?php echo "/jadrolinija/nova_karta.php" . "?edit=true&putnik="; ?>" + putnik + "&linija=" + linija + "&brod=" + brod;;
		}
	</script>
</html>
