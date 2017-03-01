<div class="container">
	<?php

//funkcja formatująca datę na przyjazny format bądź poprawny w bazie danych
//data, godzina, przesunięcie minutowe, typ zwracanego formatu H = Godzina:Minuta || Y-m-d H:i:s
	function zmianaDaty($data, $godzina, $min, $typ = null) {
		$today = new DateTime($data);
	//Konwertowanie na format obiektu godziny
		$godzina .= ":00:00";
		$today->modify($godzina);
	//Aktualna data
		$date = new DateTime($today->format("Y-m-d H:i:s"));
	//Przesunięcie minutowe czasu
		$date->modify("+".$min." minutes");
		if ($typ == "H") {
			return $date->format("H:i");
		}
		return $date->format("Y-m-d H:i:s");
	}
//pętla to Float więc w przypadku 11.00 zwróci false co będzie idealne dla przekazywania poprawnych wartości int
	function isTrueFloat($val) 
	{ 
		return ((int)$val != $val) ;
	}

	function czyWolnyGokart($data, $gokart) {
		$db = Baza::dajDB();
		$zap = $db->prepare("SELECT id FROM `rezerwacje` WHERE `data` = '".$data."' AND `tor` = ".$gokart." AND `potwierdzenie` = 1 LIMIT 1");
		$zap->execute();
		if ($zap->rowCount() > 0) {
			return false;
		}
		return true;
	}

	$aktualna = new DateTime();
	echo '<table class="table table-sm">
	<thead>
		<tr>
			<th>Godzina</th>
			<th>Dostępność</th>
		</tr>
	</thead>
	<tbody>';
		
		for ($i=12; $i <= 23.5; $i += 0.5) { 
	//jeśli 12.30 wtedy wyświetlamy aktualną godzinę wraz z przesunięciem podanym tuż po niej
			echo "<tr>";
			if (isTrueFloat($i)) {
				echo "<th scope='row'>".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 30, "H")."</th>";

				if ($aktualna->format("H") >= (int)$i ) {
					echo "<td class='table-warning'>Nie można już zarezerwować</td>";
				}
				else
				{
					if (czyWolnyGokart(zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 30), 1)) {
						echo "<td class='table-success'>Wolny</td>";
					}
					else
					{
						echo "<td class='table-danger'>Zajęty</td>";
					}
				}
			}
			else {
				echo "<th scope='row'>".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 0, "H")."</th>";

				if ($aktualna->format("H") >= (int)$i ) {
					echo "<td class='table-warning'>Nie można już zarezerwować</td>";
				}
				else
				{
					if (czyWolnyGokart(zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 0), 1)) {
						echo "<td class='table-success'>Wolny</td>";
					}
					else
					{
						echo "<td class='table-danger'>Zajęty</td>";
					}
				}

			}
			echo "</tr>";
		}
		

		echo ' </tbody>
	</table>';
	?>
</div>