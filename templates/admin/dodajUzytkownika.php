<div class="container">
	<?php
//ładowanie funkcji z katalogu /fx/
	fx('rejestracja');
//jak login nie jest pusty to przesyłamy dane do funkcji
	if(!empty($_POST['login'])){
		echo rejestracja($_POST['login'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['imie'], $_POST['nazwisko'], $_POST['telefon'], $_POST['waga']);
	}
	else {
		$len = 8;
		$r = substr(sha1(rand(1,10000)),0,$len);
		$len2 = 6;
		$login = substr(sha1(rand(1,10000)),0,$len2);
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
				<input type="hidden" name="login" value="'.$login.'">
				<input type="hidden" name="password1" value="'.$r.'">
				<input type="hidden" name="password2" value="'.$r.'">
				<div>
					<label for="password">Waga: </label><br />
					<input type="text" name="waga"/>
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
</div>