<?php
	require_once 'connection.php';
	$brodovi = array();
	$sql = "SELECT * FROM brod";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($brodovi, $row);
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
					<li><a class="active" href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content"><div class="left">
				<ul class="left-nav">
					<li><a class="active" href="brod.php">Popis brodova</a></li>
					<li><a href="novi_brod.php">Novi brod</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<?php if (count($brodovi) === 0) { ?>
						<h3 style="padding-left: 20px;">Nema nijednog broda</h3>
					<?php } else { ?>
					<section>
						<table class="table">
							<thead>
								<tr>
									<td>Sifra broda</td>
									<td>Naziv broda</td>
									<td>Kapacitet putnika</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($brodovi as $brod) { ?>
								<tr>
									<td><?php echo $brod["sifBrod"]; ?></td>
									<td><?php echo $brod["nazivBrod"]; ?></td>
									<td><?php echo $brod["kapacitetPutnici"]; ?></td>
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
