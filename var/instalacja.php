<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Gokart</title>

</head>
<body>
	<?php

	$baza = '
	<form id="register_form" action="instalacja.php?step=2" method="POST">
		<fieldset>
			<legend>Dane do bazy</legend>
			<div>
				<label for="dbLogin">Login:</label><br />
				<input name="login" required>
			</div>

			<div>
				<label for="dbPassword">Hasło:</label><br />
				<input type="password" name="password">
			</div>

			<div>
				<label for="dbName">Nazwa bazy:</label><br />
				<input name="baza" required>
			</div>

			<div>
				<label for="dbHost">Host:</label><br />
				<input name="host" value="localhost" required>
			</div>

			<input type="submit" value="Wyślij" />
		</fieldset>
	</form>
	';

	$admin = '
	<form id="register_form" action="instalacja.php?step=3" method="POST">
		<fieldset>
			<legend>Dane do konta admina</legend>
			<div>
				<label for="dbLogin">Login:</label><br />
				<input name="login" required>
			</div>

			<div>
				<label for="dbPassword">Hasło:</label><br />
				<input type="password" name="password" required>
			</div>

			<input type="submit" value="Wyślij" />
		</fieldset>
	</form>
	';

	$finall = '<h2>Poprawnie skonfigurowano serwis<br />
	<a href="../index.php">Przejdź dalej</a>
</h2>';

isset($_GET['step']) ? null : $_GET['step'] = 1;
switch ($_GET['step']) {

	case '1':
	echo $baza;
	break;

	case '2':

	$dsn = "mysql:dbname=".$_POST['baza'].";host=".$_POST['host'].";port=3306";
	$username = $_POST['login'];
	$password = $_POST['password'];
	try {
		$db = new PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$db->exec("set names utf8");
	} catch (PDOException $e)
	{
		echo "Nie udało sie połaczyć z bazą danych!<br />";
		echo $e->getMessage();
		exit();
	}


	$myfile = fopen("baza.php", "w+") or die("Nie można utworzyć pliku sprawdź CHMOD'y!");
	$txt = '<?php
	class Baza
	{
		public $db;
		static public function dajDB()
		{
			if(!isset($db) || $db==null)
			{
				$dsn = "mysql:dbname='.$_POST['baza'].';host='.$_POST['host'].';port=3306";
				$username = "'.$_POST['login'].'";
				$password = "'.$_POST['password'].'";
				try {
					$db = new PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					$db->exec("set names utf8");
				} catch (PDOException $e)
				{
					echo $e->getMessage();
				}
			}
			return $db;
		}
	}
	?>';
	fwrite($myfile, $txt);

	require_once('baza.php');
	$db = Baza::dajDB();

	$tab1 = "CREATE TABLE `gokarty` (
	`id` int(11) NOT NULL,
	`nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
	`opis` tinytext COLLATE utf8_polish_ci NOT NULL,
	`ilosc` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;";
	$db->exec($tab1);

	$tab1a = "INSERT INTO `gokarty` (`id`, `nazwa`, `opis`, `ilosc`) VALUES
	(1, 'Pogromca', 'Gokart o Mocy 10KM', 9),
	(2, 'Starter', 'Gokart o Mocy 6KM', 7),
	(3, 'Rakieta', 'Gokart tandem (2 osobowy) o mocy 13KM', 13);";
	$db->exec($tab1a);

	$tab2 = "CREATE TABLE `koszyk` (
	`id` int(11) NOT NULL,
	`id_uzytkownika` int(11) NOT NULL,
	`id_produktu` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$db->exec($tab2);

	$tab3 = "CREATE TABLE `produkty` (
	`id` int(11) NOT NULL,
	`nazwa` varchar(30) NOT NULL,
	`cena` float NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$db->exec($tab3);

	$tab3a = "INSERT INTO `produkty` (`id`, `nazwa`, `cena`) VALUES
	(1, 'piwo', 5),
	(2, 'Kominiarka My Litlle Pony', 10),
	(3, 'Gokart 6KW', 40),
	(4, 'Gokart 10KM', 50),
	(5, 'Tandem', 45),
	(6, 'castko z krymem', 6.5);";
	$db->exec($tab3a);

	$tab4 = "CREATE TABLE `rezerwacje` (
	`id` int(11) NOT NULL,
	`id_uzytkownika` int(11) NOT NULL,
	`data` datetime NOT NULL,
	`ilosc` int(11) NOT NULL,
	`gokart` tinyint(4) NOT NULL,
	`potwierdzenie` tinyint(1) NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;";
	$db->exec($tab4);

	$tab5 = "CREATE TABLE `uzytkownicy` (
	`id` int(11) NOT NULL,
	`login` varchar(25) COLLATE utf8_polish_ci NOT NULL,
	`imie` varchar(25) COLLATE utf8_polish_ci NOT NULL,
	`nazwisko` varchar(25) COLLATE utf8_polish_ci NOT NULL,
	`telefon` varchar(12) COLLATE utf8_polish_ci NOT NULL,
	`email` varchar(35) COLLATE utf8_polish_ci NOT NULL,
	`password` varchar(40) COLLATE utf8_polish_ci NOT NULL,
	`ranga` int(11) NOT NULL DEFAULT '0',
	`waga` float NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;";
	$db->exec($tab5);

	$query = "ALTER TABLE `gokarty`
	ADD PRIMARY KEY (`id`);

	ALTER TABLE `koszyk`
	ADD PRIMARY KEY (`id`);

	ALTER TABLE `produkty`
	ADD PRIMARY KEY (`id`);

	ALTER TABLE `rezerwacje`
	ADD PRIMARY KEY (`id`);

	ALTER TABLE `uzytkownicy`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `login` (`login`),
	ADD UNIQUE KEY `email` (`email`);

	ALTER TABLE `gokarty`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

	ALTER TABLE `koszyk`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

	ALTER TABLE `produkty`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

	ALTER TABLE `rezerwacje`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

	ALTER TABLE `uzytkownicy`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
	$db->exec($query);

	echo $admin;
	break;

	case '3':
	if (!empty($_POST['login'])) {
		require_once('baza.php');
		$db = Baza::dajDB();
		$query = "INSERT INTO `uzytkownicy` (`login`, `password`, `ranga`) VALUES ('".$_POST['login']."', '".sha1($_POST['password'])."', '2')";
		$db->exec($query);
		echo "Utworzono konto administratora, teraz możesz się zalogować<br />";
	}
	echo $finall;
	break;

	default:
	echo $baza;
	break;
}
?>
</body>
</html>