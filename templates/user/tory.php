<?php
function czyWolny($data, $godzina, $tor)
{
	$db = Baza::dajDB();
	//Delikatna korekta godziny z pętli
	$godzina .= ":00:00";
	//Tworzenie obiektu wyswietlajacego czas
	$today = new DateTime();
	//Modyfikacja godziny w obiekcie
	$today->modify($godzina);
	//Ustalenie formatu daty przekazanej w poniższym zapytaniu
	$data = $today->format("Y-m-d H:i:s");

	$zap = $db->prepare("SELECT id FROM `rezerwacje` WHERE `data` = '".$data."' AND `tor` = ".$tor." AND `potwierdzenie` = 1 LIMIT 1");
	$zap->execute();
	$dane = $zap->fetchAll(PDO::FETCH_COLUMN, 0);
	//Jeśli znaleziono rekord to 
	if (count($dane) == 1) {
		return false;
	}
	return true;
}

function rezerwacjaToru($id_uzytkownika, $godzina, $tor){
	$db = Baza::dajDB();
	$godzina .= ":00:00";
	$today = new DateTime();
	$today->modify($godzina);
	$data = $today->format("Y-m-d H:i:s");

	$zap = $db->prepare("INSERT INTO `rezerwacje` (`id_uzytkownika`, `data`, `tor`) VALUES (:id_uzytkownika, :data, :tor)");
	$zap->bindValue(":id_uzytkownika", $id_uzytkownika, PDO::PARAM_INT);
	$zap->bindValue(":data", $data, PDO::PARAM_STR);
	$zap->bindValue(":tor", $tor, PDO::PARAM_INT);
	$zap->execute();
}


if (!empty($_GET['s2'])) {

	if (empty($_POST)) {
		$today = new DateTime();

		$otwarcie = 12;
		$zamkniecie = 24;
		$ilosc_torow = 1;

		echo "
		<form id='rezerwacja' action='' method='POST'>
			<fieldset>
				<table style='text-align:center'>\n";
					for ($i=$otwarcie-1; $i<$zamkniecie; $i++) {
						echo "<tr>";
						for ($j = 1; $j <= $ilosc_torow; $j++) {
							if($j == 1) {
								if ($i==$otwarcie-1) {
									echo "<td>Godzina</td>\n";
								}else {
									echo "<td> ".$i."</td>\n";
								}
							}
							if ($i == $otwarcie-1) {
								echo "<td>Tor ".$j."</td>\n";
								echo "<td>Rezerwacja</td>\n";
							}
							else {
								if (czyWolny($today->format("Y-m-d"), $i, $_GET['s2'])) {
									echo "<td>Wolny</td>\n";
									echo "<td><input type='checkbox' name='box_tablica[]' value='".$today->format("Y-m-d").",".$i.",".$_GET['s2']."'></td>\n";
								}
								else
								{
									echo "<td>Zajęty</td>\n";
									echo "<td><input type='checkbox' name='' disabled readonly></td>\n";
								}
							}
						}
						echo "</tr>\n";
					}
					echo "</table>
					<input type='submit' value='Zarezerwuj' />
				</fieldset>
			</form>";
		}
		else
		{
			echo "Dokonano wstępnej rezerwacji na godziny:";
			foreach ($_POST['box_tablica'] as $key => $value) {
				//Rozdzielam tablicę po przecinkach, 0-Data, 1-Godzina, 2-Tor
				$dane = explode(",", $value);
				echo " ".$dane[1].",";
				rezerwacjaToru($Uzytkownik->getId(), $dane[1], $dane[2]);
			}
			echo "<br />";
			echo "Tory zostały wysłane do akceptacji rezerwacji, nasi konsultanci oddzwonią w celu dokonania weryfikacji zamówienia";
		}
	}
	else {

		$db = Baza::dajDB();
		$zap = $db->query("SELECT `id`,`nazwa_toru` FROM `tory`");
		echo "Wybierz tor:<br />";
		while($tab = $zap->fetch()){
			echo "<a href='".$page."/".$tab['id']."'>".$tab['nazwa_toru']."</a> |";
		}
	}
	?>