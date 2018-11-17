<?php
	require_once 'connection.php';
	$karte = array();
	$sql = "SELECT CONCAT(imePutnik, ' ', prezimePutnik) as ime, CONCAT(p1.nazivPristanista, ' - ', p2.nazivPristanista) as linija, brod.nazivBrod as brod, datKarte, CONCAT(linija.dan, ' - ', linija.satOdlaska) as odlazak FROM putnik JOIN karta ON karta.sifPutnika = putnik.sifPutnik JOIN linija on karta.sifLinije = linija.sifraLinije JOIN pristaniste p1 on linija.sifraOdlaznogPristanista = p1.sifPristanista JOIN pristaniste p2 ON linija.sifraDolaznogPristanista = p2.sifPristanista JOIN brod on brod.sifBrod = karta.sifBroda;";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($karte, $row);
			}
		}
		mysqli_free_result($result);
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
</html>
