<?php
//Obiektowy routing do zrobienia na inne czasy
/*Skopana klasa router lepiej bez klasy robić by mieć dostęp do zewnętrznych zmiennych bez ładowania całych klas
class Router
{
	private $access = array();
	private $start;
	private $folder;

	public function __construct($tab = array())
	{
		switch ($this->getRole()) {
			case -1:
				$this->$access = $tab['guest'];
				$this->folder = 'templates/guest/';
				$this->start = 'home';
				break;
			case 0;
				$this->access = $tab['user'];
				$this->folder = 'templates/user/';
				$this->start = 'konto';
				break;
			case 1:
				$this->access = $tab['mod'];
				$this->start = 'konto';
				break;
			case 2:
				$this->access = $tab['admin'];
				$this->start = 'konto';
				break;
			default:
				$this->access = $tab['guest'];
				$this->start = 'konto';
				break;
		}
	}
	private function getAccess()
	{
		return $this->access;
	}
	private function getStart()
	{
		return $this->start;
	}
	private function getFolder()
	{
		return $this->folder;
	}
	private function getPage($page)
	{
		if (in_array($page, $this->getAccess())) {
			return $page;
		}
		return 'error';
	}

	public function renderPage($page)
	{
		if (empty($page)) {
			$page = $this->getStart();
		}
		else {
			$page = $this->getPage($page);
		}
		print_r($this->getRole());
		require_once($this->getFolder().'header.php');
		require_once($this->getFolder().''.$page.'.php');
		require_once($this->getFolder().'footer.php');
	}
	
}
*/
?>