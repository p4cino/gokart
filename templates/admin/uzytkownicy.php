<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Usuwanie użytkowników.</h1>
		<br />
	</div>
</div>
<div class="container">
	<?php
	$db = Baza::dajDB();

	if (!empty($_GET['s2']) && !empty($_GET['s3'])) {
		if ($_GET['s3'] == "delete") {
			$sql = "DELETE FROM `uzytkownicy` WHERE `uzytkownicy`.`id` = :id";
			$stmt = $db->prepare($sql);                                   
			$stmt->bindParam(':id', $_GET['s2'], PDO::PARAM_INT);   
			$stmt->execute(); 
		}
	}

	$zap = $db->query("SELECT `id`, `login`, `ranga` FROM `uzytkownicy` WHERE ranga < ".$Uzytkownik->getRole()." ");
	while($tab = $zap->fetch()){

		switch ($tab['ranga']) {
			case 0:
			$ranga = "Uzytkownik";
			break;
			case 1:
			$ranga = "Moderator";
			break;
			case 2:
			$ranga = "Administrator";
			break;
			default:
			$ranga = "Uzytkownik";
			break;
		}

		echo "".$tab['login']." | Ranga: ".$ranga." <a class='btn btn-outline-danger' href='?page=uzytkownicy&s2=".$tab['id']."&s3=delete'>Usuń</a><hr />";
	}
	?>
</div>