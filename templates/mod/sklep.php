<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<h1 class="display-3">Kasa.</h1>
		<br />
	</div>
</div>
<div class="container">
	<?php
	$db = Baza::dajDB();
	if (!empty($_GET['s3']) && $_GET['s3'] == "accept") {
		$zap = $db->prepare("SELECT SUM(produkty.cena) suma FROM produkty INNER JOIN koszyk WHERE koszyk.id_produktu = produkty.id AND id_uzytkownika = ".$Uzytkownik->getId()."");
		$zap->execute();
		$suma = $zap->fetch(PDO::FETCH_ASSOC);

		echo '<div class="alert alert-success m-0" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Do zapłaty:</strong> '.$suma['suma'].'$
	</div>';

	$sql = "DELETE FROM `koszyk` WHERE `id_uzytkownika` = ".$Uzytkownik->getId()." ";
	$stmt = $db->prepare($sql);                                   
	$stmt->execute(); 
}
?>
<div class="row">
	<div class="col-6">
		<h2>Produkty <p class='small'>(Klik by dodać do listy)</p></h2>
		<?php
		$db = Baza::dajDB();
		if (!empty($_GET['s2']) && !empty($_GET['s3'])) {

			if ($_GET['s3'] == "dodaj") {
				$sql = "INSERT INTO `koszyk` (`id`, `id_uzytkownika`, `id_produktu`) VALUES (NULL, '".$Uzytkownik->getId()."', :idproduktu)";
				$stmt = $db->prepare($sql);                              
				$stmt->bindValue(':idproduktu', $_GET['s2'], PDO::PARAM_STR);
				$stmt->execute(); 
			}
			if ($_GET['s3'] == "delete") {
				$sql = "DELETE FROM `koszyk` WHERE `id` = :id";
				$stmt = $db->prepare($sql);                                   
				$stmt->bindParam(':id', $_GET['s2'], PDO::PARAM_INT);   
				$stmt->execute(); 
			}

		}
		if (!empty($_GET['s3']) && $_GET['s3'] == "clean") {
			$sql = "DELETE FROM `koszyk` WHERE `id_uzytkownika` = ".$Uzytkownik->getId()." ";
			$stmt = $db->prepare($sql);                                   
			$stmt->execute(); 
		}

		$zap = $db->query("SELECT * FROM produkty");
		while($tab = $zap->fetch()){
			echo "<a class='btn btn-warning btn-lg my-2 mx-2' href='?page=sklep&s2=".$tab['id']."&s3=dodaj'>".$tab['nazwa']." | ".$tab['cena']."$</a>";
		}
		?>
	</div>

	<div class="col-6">
		<h2>Podsumowanie <p class='small'>(Klik by usunąć dany produkt)</p></h2>
		<?php
		$zap = $db->query("SELECT produkty.nazwa, produkty.cena, koszyk.id FROM produkty INNER JOIN koszyk WHERE koszyk.id_produktu = produkty.id AND id_uzytkownika = ".$Uzytkownik->getId()." ");
		$ile = false;
		while($tab = $zap->fetch()){
			$ile = true;
			echo "<a class='btn btn-danger btn-lg my-2 mx-2' href='?page=sklep&s2=".$tab['id']."&s3=delete'>".$tab['nazwa']." | ".$tab['cena']."$</a>";
		}
		if (!$ile) {
			echo "Wprowadź produkt";
		}
		else
		{
			$zap = $db->prepare("SELECT SUM(produkty.cena) suma FROM produkty INNER JOIN koszyk WHERE koszyk.id_produktu = produkty.id AND id_uzytkownika = ".$Uzytkownik->getId()."");
			$zap->execute();
			$suma = $zap->fetch(PDO::FETCH_ASSOC);
			echo "<p class='text-right lead'><strong>".$suma['suma']."$</strong></p>
			<hr />
			<a class='btn btn-success btn-lg my-2 mx-2' href='?page=sklep&s3=accept'>Podsumowanie</a>
			<a class='btn btn-secondary btn-lg my-2 mx-2' href='?page=sklep&s3=clean'>Wyczyść wszystko</a>";
		}
		?>
	</div>

</div>
</div>