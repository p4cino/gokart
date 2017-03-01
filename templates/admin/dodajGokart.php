<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Dodawanie Gokarta.</h1>
		<br />
	</div>
</div>
<?php
if(!empty($_POST['nazwa']) && !empty($_POST['opis'])){
	$db = Baza::dajDB();
	$zap = $db->prepare("INSERT INTO gokarty (nazwa, opis, ilosc) VALUES (:nazwa, :opis, :ilosc)");
	$zap->bindValue(":nazwa", $_POST['nazwa'], PDO::PARAM_STR);
	$zap->bindValue(":opis", $_POST['opis'], PDO::PARAM_STR);
	$zap->bindValue(":ilosc", $_POST['ilosc'], PDO::PARAM_INT);
	$zap->execute();
	echo '<div class="alert alert-success m-0" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Sukces!</strong> Dodano Nowego Gokarta!
</div>';
}
?>
<div class="container">
	<form role="form" method="POST">
		<div class="form-group">
			<label for="name">Nazwa Gokarta</label>
			<div class="input-group Name">
				<input type="text" class="form-control" name="nazwa" required>
			</div>
		</div>
		<div class="form-group">
			<label for="exampleTextarea">Opis Gokarta</label>
			<textarea class="form-control" name="opis" rows="3" required></textarea>
		</div>
		<div class="form-group">
			<label for="name">Ilosć Gokartów Tego Typu</label>
			<div class="input-group Name">
				<input type="text" class="form-control" name="ilosc" required>
			</div>
		</div>

		<button type="submit" class="btn btn-primary">Dodaj</button>
	</form>
</div>