<?php
//ładowanie funkcji z katalogu /fx/
fx('rejestracja');
//jak login nie jest pusty to przesyłamy dane do funkcji
if(!empty($_POST['login'])){
	echo rejestracja($_POST['login'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['imie'], $_POST['nazwisko'], $_POST['telefon']);
}
else {
	echo '
	<form id="register_form" action="" method="POST">
		<fieldset>
			<legend>Rejestracja</legend>
			<div>
				<label for="password">Imie: </label><br />
				<input pattern=".{4,}" name="imie"  required title="Minimum 4 znaki">
			</div>
			<div>
				<label for="password">Nazwisko: </label><br />
				<input type="text" name="nazwisko"/>
			</div>
			<div>
				<label for="password">Telefon: </label><br />
				<input type="text" name="telefon"/>
			</div>
			<div>
				<label for="login">Login: </label><br />
				<input type="text" name="login"/>
			</div>
			<div>
				<label for="password">Hasło: </label><br />
				<input type="password" name="password1"/>
			</div>
			<div>
				<label for="password">Powtórz hasło: </label><br />
				<input type="password" name="password2"/>
			</div>
			<div>
				<label for="password">Email: </label><br />
				<input type="text" name="email"/>
			</div>
			<input type="submit" value="Wyślij" />
		</fieldset>
	</form>
	';
}

?>