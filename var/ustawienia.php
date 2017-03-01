<?php
session_start();
//Funkcja skracająca ładowanie funkcji
function fx($name) 
{
	$page =  './fx/'.$name.'.php';
	require_once($page);
}
//Klasa tworząca Singleton służący do połączenia się z bazą 
require_once('baza.php');
//Klasa użytkownik odpowiadająca za wszystkie operacje bezpośrednio z nim związanymi 
class Uzytkownik
{
	private $id;
	private $imie;
	private $nazwisko;
	private $telefon;
	private $email;
	private $password;
	private $role;
	public $db;

	public function __construct($id)
	{
		if (isset($id) && is_numeric($id)) 
		{
			$db = Baza::dajDB();

			$zap = $db->prepare("SELECT * FROM uzytkownicy WHERE id = :id");
			$zap->bindValue(":id", $id, PDO::PARAM_INT);
			$zap->execute();
			$tab = $zap->fetch(PDO::FETCH_ASSOC);
			$zap->closeCursor();

			$this->id = $tab['id'];
			$this->imie = $tab['imie'];
			$this->nazwisko = $tab['nazwisko'];
			$this->telefon = $tab['telefon'];
			$this->email = $tab['email'];
			$this->password = $tab['password'];
			$this->ranga = $tab['ranga'];
			$this->db = Baza::dajDB();
		}
		//Gdy nie przekazano id oraz gdy przy nim majstrowano i nie jest liczbą zwracamy range -1
		//Ranga -1 = gość na stronie i nie korzystamy z funkcji klasy Uzytkownik
		else
		{
			$this->ranga = -1;
		}
	}
	public function __destruct()
	{
	}
	//Nie wolno zmieniać ID użytkownika więc jest tylko get'er
	public function getId()
	{
		return $this->id;
	}
	public function getImie()
	{
		return $this->imie;
	}
	public function setImie($var)
	{
		$this->imie = $var;
		$zap = $this->db->prepare("UPDATE uzytkownicy SET imie = :var WHERE id = :id");
		$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
		$zap->bindValue(":var", $var, PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
	}
	public function getNazwisko()
	{
		return $this->nazwisko;
	}
	public function setNazwisko($var)
	{
		$this->nazwisko= $var;
		$zap = $this->db->prepare("UPDATE uzytkownicy SET nazwisko = :var WHERE id = :id");
		$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
		$zap->bindValue(":var", $var, PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
	}
	public function getRole()
	{
		return $this->ranga;
	}
	public function getTelefon()
	{
		return $this->telefon;
	}
	public function setTelefon($var)
	{
		$zap = $this->db->prepare("UPDATE uzytkownicy SET telefon = :var WHERE id = :id");
		$this->telefon = $var;
		$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
		$zap->bindValue(":var", $var, PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($var)
	{
		$this->email = $var;
		$zap = $this->db->prepare("UPDATE uzytkownicy SET email = :var WHERE id = :id");
		$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
		$zap->bindValue(":var", $var, PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
	}
	public function setPassword($var)
	{
		$zap = $this->db->prepare("UPDATE uzytkownicy SET password = :var WHERE id = :id");
		$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
		$zap->bindValue(":var", sha1($var), PDO::PARAM_STR);
		$zap->execute();
		$zap->closeCursor();
	}
	public function setRole($up, $id)
	{
		$this->ranga = $var;
		$zap = $this->db->prepare("UPDATE uzytkownicy SET ranga = :var WHERE id = :id");
		$zap->bindValue(":var", $var, PDO::PARAM_INT);
		$zap->bindValue(":id", $id, PDO::PARAM_INT);
		$zap->execute();
		$zap->closeCursor();
	}

}

function reload($where)
{ 
	if ($where == '') {
		header("Location: index.php"); 
	}
	else {
		header("Location: index.php?page=".$where.""); 
	}
}
?>