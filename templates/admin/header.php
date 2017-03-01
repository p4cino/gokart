<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<!--Ikonki-->
	<link rel="stylesheet" href="./bootstrap-4.0.0-alpha.5-dist/css/font-awesome.min.css">
</head>

<body>
	<nav class="navbar navbar-inverse navbar-toggleable-md bg-inverse">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#rozwin" aria-controls="rozwin" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href=""><i class="fa fa-grav"></i>Gokart</a>

		<div class="collapse navbar-collapse" id="rozwin">

			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="?page=pa">Panel Administratora</a>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Użytkownicy
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="?page=dodajUzytkownika">Dodaj uzytkownika</a>
						<a class="dropdown-item" href="?page=uzytkownicy">Usuwanie użytkowników</a>
						<a class="dropdown-item" href="?page=role">Przydzielanie Praw</a>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gokarty
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="?page=dodajGokart">Dodaj Gokarty</a>
						<a class="dropdown-item" href="?page=usunGokart">Usuń</a>
						<a class="dropdown-item" href="?page=edytujGokart">Edytuj</a>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Produkty
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="?page=dodajProdukt">Dodaj</a>
						<a class="dropdown-item" href="?page=usunProdukt">Usuń</a>
						<a class="dropdown-item" href="?page=edytujProdukt">Edytuj</a>
					</div>
				</li>
			</ul>

			<form class="form-inline my-2 my-lg-0">
				<a href="?page=logout" class="btn btn-outline-danger mx-2">Wyloguj <i class="fa fa-sign-out" aria-hidden="true"></i></a>
			</form>
		</div>
	</nav>