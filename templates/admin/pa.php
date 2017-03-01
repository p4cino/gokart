<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Witaj <?php echo $Uzytkownik->getImie(); ?>.</h1>
		<p class="lead">W tym panelu masz dostęp do wszystkiego.</p>
		<br />
	</div>
</div>

<div class ="container">
	<?php
	if (!empty($_POST)) {
		echo '<div class="alert alert-success m-0" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Zaktualizowano Dane!
	</div>';
	$Uzytkownik->setImie($_POST['inputName']);
	$Uzytkownik->setNazwisko($_POST['inputSurname']);
	$Uzytkownik->setTelefon($_POST['inputPhone']);
	$Uzytkownik->setEmail($_POST['inputEmail']);
}
if(!empty($_POST['inputPassword']) && !empty($_POST['inputPassword2']) && (sha1($_POST['inputPassword']) === sha1($_POST['inputPassword2'])) )
{
	if (isset($_POST['inputPassword']) && strlen($_POST['inputPassword']) > 6) {
		$Uzytkownik->setPassword($_POST['inputPassword']);
		echo '<p class="alert-success text-center">Zaktualizowano Hasło</p>';
	}
	else {
		echo '<div class="alert alert-danger m-0" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Błąd!</strong> Hasło musi mieć więcej niż 6 znaków!
	</div>';
}
}
?>
<div class="row">
	<div class="col-6">

		<form role="form" method="POST">
			<div class="form-group">
				<label for="name">Imię</label>
				<div class="input-group Name">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" value="<?php echo $Uzytkownik->getImie(); ?>" class="form-control" name="inputName" required>
				</div>
			</div>

			<div class="form-group">
				<label for="surname">Nazwisko</label>
				<div class="input-group Name">
					<span class="input-group-addon"><i class="fa fa-user-o"></i></span>
					<input type="text" value="<?php echo $Uzytkownik->getNazwisko(); ?>" class="form-control" name="inputSurname" required>
				</div>
			</div>

			<div class="form-group">
				<label for="inputPhone">Numer Telefonu</label>
				<div class="input-group phone">
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
					<input type="phone" value="<?php echo $Uzytkownik->getTelefon(); ?>" class="form-control" name="inputPhone" required>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail">Adres Email</label>
				<div class="input-group email">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					<input type="email" value="<?php echo $Uzytkownik->getEmail(); ?>" class="form-control" name="inputEmail" required>
				</div>
			</div>
			<div class="alert alert-info" role="alert">
				W przypadku zmiany hasła należy wprowadzić nowe <strong>dwukrotnie</strong>.
			</div>
			<div class="form-group">
				<label for="inputPhone">Hasło</label>
				<div class="input-group phone">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="inputPassword">
				</div>
			</div>

			<div class="form-group">
				<label for="inputPhone">Hasło</label>
				<div class="input-group phone">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="inputPassword2">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Aktualizuj</button>
		</form>
	</div>

	<div class="col-6 embed-responsive embed-responsive-16by9">

	</div>

</div>

</div>