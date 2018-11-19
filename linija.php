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

	if (isset($_GET["delete"]) && isset($_GET["id"])) {
		if ($_GET["delete"] == true) {
			$id = $_GET["id"];
			require_once 'connection.php';
			$sql = "DELETE FROM linija WHERE sifraLinije = $id";
            if (mysqli_query($conn, $sql)) {
                echo '<script> 
                	alert("Linija uspješno obrisana"); 
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
					<li><a class="active" href="linija.php">Linija</a></li>
					<li><a href="brod.php">Brod</a></li>
					<li><a href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
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
									<td>Akcija</td>
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
									<td><button type="button" onclick="brisi(<?php echo $linija["sifraLinije"]; ?>);  return false;">Obriši</button><button onclick="uredi(<?php echo $linija["sifraLinije"]; ?>);  return false;">Uredi</button></td>
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
		function brisi(id) {
			var cfrm = confirm("Jeste li sigurni da želite obrisati?");
			if (cfrm == true) {
				window.location.href = "<?php echo $_SERVER["PHP_SELF"] . "?delete=true&id="; ?>" + id;
			}
		}
		function uredi(id) {
			window.location.href = "<?php echo "/jadrolinija/nova_linija.php" . "?edit=true&id="; ?>" + id;
		}
	</script>
</html>
