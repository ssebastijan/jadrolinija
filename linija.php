<?php
	require_once 'connection.php';
	$linije = array();
	$sql = "SELECT sifraLinije, satOdlaska, satDolaska, dan, p1.nazivPristanista as odlaznoPristaniste, p2.nazivPristanista as dolaznoPristaniste from linija join pristaniste p1 on linija.sifraOdlaznogPristanista = p1.sifPristanista join pristaniste p2 on linija.sifraDolaznogPristanista = p2.sifPristanista;";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($linije, $row);
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
					<li><a class="active" href="linija.php">Linija</a></li>
					<li><a href="karta.php">Karta</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a class="active" href="linija.php">Popis linija</a></li>
					<li><a href="nova_linija.php">Nova linija</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<?php if (count($linije) === 0) { ?>
						<h3 style="padding-left: 20px;">Nema nijedne upisane linije</h3>
					<?php } else { ?>
					<section>
						<table class="table">
							<thead>
								<tr>
									<td>Sifra</td>
									<td>Vrijeme odlaska</td>
									<td>Vrijeme dolaska</td>
									<td>Dan</td>
									<td>Odlazno pristanište</td>
									<td>Dolazno pristanište</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($linije as $linija) { ?>
								<tr>
									<td><?php echo $linija["sifraLinije"]; ?></td>
									<td><?php echo $linija["satOdlaska"]; ?></td>
									<td><?php echo $linija["satDolaska"]; ?></td>
									<td><?php echo $linija["dan"]; ?></td>
									<td><?php echo $linija["odlaznoPristaniste"]; ?></td>
									<td><?php echo $linija["dolaznoPristaniste"]; ?></td>
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
