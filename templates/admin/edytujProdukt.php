<div class="container">
	<?php
	$db = Baza::dajDB();

	if (!empty($_POST) && !empty($_GET['s2'])) {
		$zap = $db->prepare("UPDATE produkty SET nazwa = :nazwa, cena = :cena WHERE id = :id");
		$zap->bindValue(":id", $_GET['s2'], PDO::PARAM_INT);
		$zap->bindValue(":nazwa", $_POST['nazwa'], PDO::PARAM_STR);
		$zap->bindValue(":cena", $_POST['cena'], PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
		echo "<p class='alert-success'>Zaktualizowano Dane Produktu</p>";
	}

	if (!empty($_GET['s2']) && empty($_POST)) {

		$zap = $db->prepare("SELECT * FROM produkty WHERE id = :id");
		$zap->bindValue(":id", $_GET['s2'], PDO::PARAM_INT);
		$zap->execute();
		$tab = $zap->fetch(PDO::FETCH_ASSOC);
		$zap->closeCursor();

		echo '<form role="form" method="POST">
		<div class="form-group">
			<label for="name">Nazwa</label>
			<div class="input-group Name">
				<input type="text" value="'.$tab['nazwa'].'" class="form-control" name="nazwa" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPhone">Ilość</label>
			<div class="input-group phone">
				<input type="phone" value="'.$tab['cena'].'" class="form-control" name="cena" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Aktualizuj</button>
	</form>';
}
if (empty($_GET['s2'])) {
	$zap = $db->query("SELECT id, nazwa FROM `produkty`");
	while($tab = $zap->fetch()){
		echo "Produkt: ".$tab['nazwa']."\t
		<a class='btn btn-outline-danger' href='?page=edytujProdukt&s2=".$tab['id']."'>Edycja</a><hr />";
	}
}
?>
</div>