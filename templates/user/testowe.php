<div class="jumbotron jumbotron-fluid bg-inverse" id="bg2">
	<div class="container">
		<h1 class="display-3">Rezerwacja toru</h1>
		<p class="lead">Wybierz datę a następnie godzinę rezerwacji.</p>
		<br />
	</div>
</div>
<div class="container text-center">

	<?php

	function czyWolny($data, $godzina, $tor)
	{
		$db = Baza::dajDB();
	//Delikatna korekta godziny z pętli
		$godzina .= ":00:00";
	//Tworzenie obiektu wyswietlajacego czas
		$today = new DateTime($data);
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

	function czyIstnieje($tor){
		$db = Baza::dajDB();
		$zap = $db->prepare("SELECT id FROM `tory` WHERE id = :id");
		$zap->bindValue(":id", $tor, PDO::PARAM_STR);
		$zap->execute();
		$user = $zap->fetchAll(PDO::FETCH_COLUMN, 0);
		$ile = count($user);
		if($ile == 1) {
			return true;
		}
		return false;
	}

	//Zmienna często używana z aktualną datą
	$aktualna = new DateTime();
	$formularzData = '
	<form role="form" method="POST" action="">
		<div class="form-group row">
			<label for="example-date-input" class="col-2 col-form-label">Wybierz datę rezerwacji</label>
			<div class="col-10">
				<input class="form-control" type="date" value="'.$aktualna->format("Y-m-d").'" name="date">
			</div>
		</div>
		<div class="btn-group">
			<button type="button" class="btn btn-danger" onclick="window.history.back()">Cofnij</button>
			<button type="submit" class="btn btn-success" >Dalej</button>
		</div>
	</form>';
	if (czyIstnieje($_GET['s2'])) {


		if (empty($_POST)) {
			echo $formularzData;
		}

		if (!empty($_POST['date'])) {
			if (strtotime($_POST['date']) >= strtotime($aktualna->format("Y-m-d"))) {
				$today = new DateTime($_POST['date']);
				print_r($today);
				$otwarcie = 12;
				$zamkniecie = 24;
				$ilosc_torow = 1;

				echo "
				<form action='' method='POST'>
					<fieldset>
						<table class='table table-striped' style='text-align:center'>\n";
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
										echo "<td>Stan</td>\n";
										echo "<td>Rezerwacja</td>\n";
									}
									else {
										if (czyWolny($today->format("Y-m-d"), $i, $_GET['s2'])) {
											if ($aktualna->format("Y-m-d") == $today->format("Y-m-d") && $aktualna->format("H") > $i) {
												echo "<td>Nieaktywny</td>";
												echo "<td><input type='checkbox' name='' disabled readonly></td>\n";
											}
											else
											{
												echo "<td>Wolny</td>\n";
												echo "<td><input type='checkbox' name='box_tablica[]' value='".$today->format("Y-m-d").",".$i.",".$_GET['s2']."'></td>\n";
											}
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
							<button type='submit' class='btn btn-success' >Rezerwuj <i class='fa fa-tags' aria-hidden='true'></i></button>
						</fieldset>
					</form>";
				}
				else {
					echo "<p class='alert-danger'><strong>Wybrano niepoprawną datę!</strong></p>";
					echo $formularzData;
				}
			}
			if (!empty($_POST['box_tablica'])) {
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
			echo '<p class="alert-danger">Nie ma takiego toru</p>
			<button type="button" class="btn btn-danger" onclick="window.history.back()">Cofnij</button>';
		}
		?>

	</div>
