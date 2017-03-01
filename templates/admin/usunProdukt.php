<div class="container">
	<?php
	$db = Baza::dajDB();
	if (!empty($_GET['s2'])) {
		$sql = "DELETE FROM `produkty` WHERE `id` = :id";
		$stmt = $db->prepare($sql);                                   
		$stmt->bindParam(':id', $_GET['s2'], PDO::PARAM_INT);   
		$stmt->execute();
		echo '<div class="alert alert-success m-0" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Usunięto Produkt!
	</div>'; 
}

$zap = $db->query("SELECT id, nazwa FROM `produkty`");
while($tab = $zap->fetch()){
	echo "Produkt: ".$tab['nazwa']."
	<a class='btn btn-outline-danger' href='?page=usunProdukt&s2=".$tab['id']."&s3=delete'>Usuń</a><hr />";
}
?>
</div>