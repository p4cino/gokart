<div class="container">
	<?php
	$db = Baza::dajDB();

	if (!empty($_POST) && !empty($_GET['s2'])) {
		$zap = $db->prepare("UPDATE gokarty SET nazwa = :nazwa, opis = :opis, ilosc = :ilosc WHERE id = :id");
		$zap->bindValue(":id", $_GET['s2'], PDO::PARAM_INT);
		$zap->bindValue(":nazwa", $_POST['nazwa'], PDO::PARAM_STR);
		$zap->bindValue(":opis", $_POST['opis'], PDO::PARAM_STR);
		$zap->bindValue(":ilosc", $_POST['ilosc'], PDO::PARAM_INT);
		$zap->execute();
		$zap->closeCursor();
		echo "<p class='alert-success'>Zaktualizowano Dane Gokartu</p>";
	}

	if (!empty($_GET['s2']) && empty($_POST)) {

		$zap = $db->prepare("SELECT * FROM gokarty WHERE id = :id");
		$zap->bindValue(":id", $_GET['s2'], PDO::PARAM_INT);
		$zap->execute();
		$tab = $zap->fetch(PDO::FETCH_ASSOC);
		$zap->closeCursor();

		echo '<form role="form" method="POST">
		<div class="form-group">
			<label for="name">Nazwa</label>
			<div class="input-group Name">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" value="'.$tab['nazwa'].'" class="form-control" name="nazwa" required>
			</div>
		</div>

		<div class="form-group">
			<label for="surname">Opis</label>
			<div class="input-group Name">
				<span class="input-group-addon"><i class="fa fa-user-o"></i></span>
				<input type="text" value="'.$tab['opis'].'" class="form-control" name="opis" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPhone">Ilość</label>
			<div class="input-group phone">
				<input type="phone" value="'.$tab['ilosc'].'" class="form-control" name="ilosc" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Aktualizuj</button>
	</form>';
}
if (empty($_GET['s2'])) {
	$zap = $db->query("SELECT id, nazwa FROM `gokarty`");
	while($tab = $zap->fetch()){
		echo "Nazwa gokartu: ".$tab['nazwa']."
		<a class='btn btn-outline-danger' href='?page=edytujGokart&s2=".$tab['id']."'>Edycja</a><hr />";
	}
}
?>
</div>