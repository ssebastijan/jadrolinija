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

	if (isset($_GET["delete"]) && isset($_GET["id"])) {
		if ($_GET["delete"] == true) {
			$id = $_GET["id"];
			require_once 'connection.php';
			$sql = "DELETE FROM luka WHERE sifraLuke = $id";
            if (mysqli_query($conn, $sql)) {
                echo '<script> 
                	alert("Luka uspješno obrisana"); 
                	window.location.href = "' . $_SERVER["PHP_SELF"] . '"; 
                </script>';
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
								<td>Akcija</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($luke as $luka) { ?>
							<tr>
								<td><?php echo $luka["sifraLuke"]; ?></td>
								<td><?php echo $luka["nazivLuke"]; ?></td>
								<td><?php echo $luka["nazivMjesta"]; ?></td>
								<td><?php echo $luka["brojPristanista"]; ?></td>
								<td><button onclick="brisi(<?php echo $luka["sifraLuke"]; ?>)">Obriši</button></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
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
