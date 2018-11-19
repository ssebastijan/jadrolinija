<?php
	require_once 'connection.php';
	$putnici = array();
	$sql = "SELECT * FROM putnik";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($putnici, $row);
			}
		}
		mysqli_free_result($result);
	}

	if (isset($_GET["delete"]) && isset($_GET["id"])) {
		if ($_GET["delete"] == true) {
			$id = $_GET["id"];
			require_once 'connection.php';
			$sql = "DELETE FROM putnik WHERE sifPutnik = $id";
			echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<script> 
                	alert("Putnik uspješno obrisan"); 
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
					<li><a class="active" href="putnik.php">Putnik</a></li>
					<li><a href="karta.php">Karta</a></li>
				</ul>
			</nav>
		</div>
		<div class="content">
			<div class="left">
				<ul class="left-nav">
					<li><a class="active" href="putnik.php">Popis putnika</a></li>
					<li><a href="novi_putnik.php">Novi putnik</a></li>
				</ul>
			</div>
			<div class="right">
				<section>
					<?php if (count($putnici) === 0) { ?>
						<h3 style="padding-left: 20px;">Nema nijednog putnika</h3>
					<?php } else { ?>
					<section>
						<table class="table">
							<thead>
								<tr>
									<td>Sifra putnika</td>
									<td>Ime putnika</td>
									<td>Prezime putnika</td>
									<td>Broj putovnice</td>
									<td>Državljanstvo</td>
									<td>Akcija</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($putnici as $putnik) { ?>
								<tr>
									<td><?php echo $putnik["sifPutnik"]; ?></td>
									<td><?php echo $putnik["imePutnik"]; ?></td>
									<td><?php echo $putnik["prezimePutnik"]; ?></td>
									<td><?php echo $putnik["brojPutovnice"]; ?></td>
									<td><?php echo $putnik["drzavljanstvo"]; ?></td>
									<td><button type="button" onclick="brisi(<?php echo $putnik["sifPutnik"]; ?>);  return false;">Obriši</button></td>
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
	</script>
</html>
