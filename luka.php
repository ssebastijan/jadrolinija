<?php
	require_once 'connection.php';
	$luke = array();
	$sql = "SELECT * FROM luka";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($luke, $row);
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
					<li><a class="active" href="luka.php">Luka</a></li>
					<li><a href="pristaniste.php">Pristanište</a></li>
					<li><a href="linija.php">Linija</a></li>
					<li><a href="karta.php">Karta</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a class="active" href="luka.php">Popis luka</a></li>
					<li><a href="nova_luka.php">Nova luka</a></li>
				</ul>
			</div>
			<div class="right">
				<?php if (count($luke) === 0) { ?>
					<h3 style="padding-left: 20px;">Nema nijedne upisane luke</h3>
				<?php } else { ?>
				<section>
					<table class="table">
						<thead>
							<tr>
								<td>Sifra</td>
								<td>Naziv</td>
								<td>Mjesto</td>
								<td>Broj pristaništa</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($luke as $key => $value) { ?>
							<tr>
								<td><?php echo $value["sifraLuke"]; ?></td>
								<td><?php echo $value["nazivLuke"]; ?></td>
								<td><?php echo $value["nazivMjesta"]; ?></td>
								<td><?php echo $value["brojPristanista"]; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</section>
				<?php }?>
			</div>
		</div>
	</body>
</html>
