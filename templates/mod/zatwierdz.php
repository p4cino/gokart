<div class="jumbotron jumbotron-fluid my-0">
	<div class="container">
		<div class="media">
			<div class="media-body">
				<h3>Zatwierdzanie rezerwacji</h3>
				Ostatni etap rezerwacji.
			</div>
		</div>
	</div>
</div>
<div class="container">
	<?php
	function rezerwacjaGokarta($id_uzytkownika, $godzina, $gokart, $data, $ilosc){
		$db = Baza::dajDB();
		$godzina .= ":00";
		$today = new DateTime($data);
		$today->modify($godzina);
		$data = $today->format("Y-m-d H:i:s");

		$zap = $db->prepare("INSERT INTO `rezerwacje` (`id_uzytkownika`, `data`, `gokart`, `potwierdzenie`, `ilosc`) VALUES (:id_uzytkownika, :data, :gokart, 1, :ilosc)");
		$zap->bindValue(":id_uzytkownika", $id_uzytkownika, PDO::PARAM_INT);
		$zap->bindValue(":data", $data, PDO::PARAM_STR);
		$zap->bindValue(":gokart", $gokart, PDO::PARAM_INT);
		$zap->bindValue(":ilosc", $ilosc, PDO::PARAM_INT);
		$zap->execute();
	}


	if (!empty($_POST['ok'])) {
		//wklepywanie do bazy
		foreach ($_POST['gokart'] as $key => $value) {
			rezerwacjaGokarta($Uzytkownik->getId(), $_POST['godzina'][$key], $value, $_POST['data'][$key], $_POST['ile'][$key]);
		}
		echo "<p class='alert-success'>Pomyślnie dodano rezerwacje do bazy!</p>";
	}
	else 
	{
		echo '
		<form action="" method="POST">
			<input type="hidden" name="ok" value="ok">';
			foreach ($_POST['box_tablica'] as $key => $value) {
				$dane = explode(",", $value);
				echo "Godzina: ".$dane[1]." Gokart: ".$dane[2]." Ilość: 
				<input type='text' name='ile[]'/><br />
				<input type='hidden' name='data[]' value='".$dane[0]."'>
				<input type='hidden' name='godzina[]' value='".$dane[1]."'>
				<input type='hidden' name='gokart[]' value='".$dane[2]."'>
				";
			}
			echo '
			<input type="submit" value="Zatwierdź" />
		</form>';
	}
	?>
</div>