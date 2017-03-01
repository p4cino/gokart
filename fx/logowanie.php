<?php
//dane wejściowe połaczenie z bazą, login, hasło
function logowanie($login, $password) {
	$db = Baza::dajDB();
 	$zap = $db->prepare("SELECT id FROM uzytkownicy WHERE login=:login AND password=:password");
    $zap->bindValue(":login", $login, PDO::PARAM_STR);
    $zap->bindValue(":password", sha1($password), PDO::PARAM_STR);
	$zap->execute();
	$user = $zap->fetchAll(PDO::FETCH_COLUMN, 0);
	$ile = count($user);
	if($ile == 1) {
		$_SESSION['gracz'] = $user[0];
		return true;
	}
	return false;
}
?>