<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Dodawanie Produktu.</h1>
		<br />
	</div>
</div>
<?php
if(!empty($_POST['nazwa']) && !empty($_POST['cena'])){
	$db = Baza::dajDB();
	$zap = $db->prepare("INSERT INTO produkty (nazwa, cena) VALUES (:nazwa, :cena)");
	$zap->bindValue(":nazwa", $_POST['nazwa'], PDO::PARAM_STR);
	$zap->bindValue(":cena", $_POST['cena'], PDO::PARAM_STR);
	$zap->execute();
	echo '<div class="alert alert-success m-0" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Sukces!</strong> Dodano Nowy produkt!
</div>';
}
?>
<div class="container">
	<form role="form" method="POST">
		<div class="form-group">
			<label for="name">Nazwa Produktu</label>
			<div class="input-group Name">
				<input type="text" class="form-control" name="nazwa" required>
			</div>
		</div>
		<div class="form-group">
			<label for="exampleTextarea">Cena</label>
			<input type="text" class="form-control" name="cena" required>
		</div>

		<button type="submit" class="btn btn-primary">Dodaj</button>
	</form>
</div>