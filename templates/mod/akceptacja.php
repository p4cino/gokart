<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Akceptacjia Rezerwacji.</h1>
		<br />
	</div>
</div>
<div class="container">
	<?php
	$db = Baza::dajDB();

	if (!empty($_GET['s2']) && !empty($_GET['s3'])) {
		if ($_GET['s3'] == "yes") {
			$sql = "UPDATE `rezerwacje` SET `potwierdzenie` = '1' WHERE `rezerwacje`.`id` = :id";
			$stmt = $db->prepare($sql);                                   
			$stmt->bindParam(':id', $_GET['s2'], PDO::PARAM_INT);   
			$stmt->execute(); 
		}
		if ($_GET['s3'] == "delete") {
			$sql = "DELETE FROM `rezerwacje` WHERE `rezerwacje`.`id` = :id";
			$stmt = $db->prepare($sql);                                   
			$stmt->bindParam(':id', $_GET['s2'], PDO::PARAM_INT);   
			$stmt->execute(); 
		}
	}

	$zap = $db->query("SELECT rezerwacje.id, rezerwacje.gokart, rezerwacje.data, rezerwacje.ilosc, uzytkownicy.imie, uzytkownicy.telefon, uzytkownicy.waga FROM rezerwacje INNER JOIN uzytkownicy ON uzytkownicy.id = rezerwacje.id_uzytkownika WHERE potwierdzenie = 0");
	while($tab = $zap->fetch()){
		echo "Imie: ".$tab['imie']." Telefon: ".$tab['telefon']." | Waga: ".$tab['waga']."kg Gokart: ".$tab['gokart']." Ilość: ".$tab['ilosc']." | Rezerwacja na: ".$tab['data']." 
		<a class='btn btn-outline-primary' href='?page=akceptacja&s2=".$tab['id']."&s3=yes'>Akceptacja</a>
		<a class='btn btn-outline-danger' href='?page=akceptacja&s2=".$tab['id']."&s3=delete'>Usuń</a><hr />";
	}
	?>
</div>