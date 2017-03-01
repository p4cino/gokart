<div class="jumbotron jumbotron-fluid my-0">
	<div class="container">
		<div class="media">

			<div class="media-body">
				<h3>Rezerwacja</h3>
				Ręczna rezerwacja toru dla nowego użytkownika bądź rezerwacji telefonicznej
			</div>
		</div>
	</div>
</div>
<div class="container">
	<?php
	function sprawdzNowe($data, $gokart) {
		//
		$db = Baza::dajDB();
		$zap = $db->query("SELECT SUM(`ilosc`) ilosc FROM rezerwacje WHERE `data` = '".$data."' AND gokart = ".$gokart." ");
		$zap->execute();
		$zap = $zap->fetch(PDO::FETCH_ASSOC);
		$ile = $zap['ilosc'];
		if($ile == null) $ile = 0;
		return $ile;
	}

	$db = Baza::dajDB();
	if (empty($_GET['s2'])) {
		$zap = $db->query("SELECT `id`,`nazwa`, `opis` FROM `gokarty`");
		echo '<div class="card-deck">';
		while($tab = $zap->fetch()){
			echo '
			<div class="card">

				<div class="card-block">
					<h4 class="card-title">Gokart '.$tab['nazwa'].'</h4>
					<p class="card-text">'.$tab['opis'].'</p>
				</div>
				<div class="card-footer">
					<a href="?page=rezerwacja&s2='.$tab['id'].'" class="btn btn-lg btn-success">Dodaj rezerwacje</a>
				</div>
			</div>';
		}
		echo "</div>";
	}
	else
	{
		if (empty($_GET['s3']) && empty($_POST['date'])) {
				//Zmienna często używana z aktualną datą
			$aktualna = new DateTime();
			echo '
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
		}
		else
		{
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
				$zap = $db->prepare("SELECT id FROM `rezerwacje` WHERE `data` = '".$data."' AND `gokart` = ".$gokart." AND `potwierdzenie` = 1 LIMIT 1");
				$zap->execute();
				if ($zap->rowCount() > 0) {
					return false;
				}
				return true;
			}

			function ileGokartow($id)
			{
				$db = Baza::dajDB();
				$zap = $db->prepare("SELECT ilosc FROM gokarty WHERE id = :id");
				$zap->bindValue(":id", $id, PDO::PARAM_INT);
				$zap->execute();
				$tab = $zap->fetch(PDO::FETCH_ASSOC);
				$zap->closeCursor();
				return $tab['ilosc'];
			}

			$aktualna = new DateTime($_POST['date']);
			$today = new DateTime();
			$iloscGokartow = ileGokartow($_GET['s2']);

			echo '<form action="?page=zatwierdz" method="POST">
			<table class="table table-sm">
				<thead>
					<tr>
						<th>Godzina</th>
						<th>Dostępność</th>
					</tr>
				</thead>
				<tbody>';

					for ($i=12; $i <= 23.5; $i += 0.5) { 
						echo "<tr>";
						if (isTrueFloat($i)) {
							echo "<th scope='row'>".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 30, "H")."</th>";
							echo "<td class='table-success'><input type='checkbox' name='box_tablica[]' value='".$aktualna->format("Y-m-d").",".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 30, "H").",".$_GET['s2']."'> <strong>".sprawdzNowe(zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 30), $_GET['s2'])."</strong>/".$iloscGokartow."</td>";
						}
						else {
							echo "<th scope='row'>".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 0, "H")."</th>";
							echo "<td class='table-success'><input type='checkbox' name='box_tablica[]' value='".$aktualna->format("Y-m-d").",".zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 0, "H").",".$_GET['s2']."'> <strong>".sprawdzNowe(zmianaDaty($aktualna->format("Y-m-d"), (int)$i, 0), $_GET['s2'])."</strong>/".$iloscGokartow."</td>";
						}
						echo "</tr>";
					}

					echo ' </tbody>
				</table>
				<button type="submit" class="btn btn-success" >Rezerwuj <i class="fa fa-tags" aria-hidden="true"></i></button>
			</form>';
			echo '<a onclick="window.history.back()" class="btn btn-outline-danger mx-2">Cofnij</a>';
		}
	}
	?>
</div>