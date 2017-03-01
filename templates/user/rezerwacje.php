<div class="jumbotron jumbotron-fluid bg-inverse my-0" id="bg1">
  <div class="container">
    <div class="media">

      <div class="media-body">
        <h3>Dane o rezerwacjach</h3>
      </div>
    </div>
  </div>
</div>

<div class="container">

  <?php
  function czyIstniejeRezerwacja($rezerwacja, $uzytkownik){
    $db = Baza::dajDB();
    $zap = $db->prepare("SELECT id FROM `rezerwacje` WHERE `id` = :id AND `id_uzytkownika` = :uzytkownik AND `data` >= NOW()");
    $zap->bindValue(":id", $rezerwacja, PDO::PARAM_INT);
    $zap->bindValue(":uzytkownik", $uzytkownik, PDO::PARAM_INT);
    $zap->execute();
    $user = $zap->fetchAll(PDO::FETCH_COLUMN, 0);
    $ile = count($user);
    if($ile == 1) {
      $zap = $db->prepare("DELETE FROM `rezerwacje` WHERE `id` = :id LIMIT 1");
      $zap->bindValue(":id", $rezerwacja, PDO::PARAM_INT);
      $zap->execute();
      return true;
    }
    return false;
  }

  if (!empty($_GET['s2'])) {
    if (czyIstniejeRezerwacja($_GET['s2'], $Uzytkownik->getId())) {
      echo '<p class="alert-success">Pomyślnie usunięto rezerwację :)</p>';
    }
    else {
      echo '<p class="alert-danger">Brak takiej rezerwacji!</p>';
    }
  }
  ?>
  <div id="accordion" role="tablist" aria-multiselectable="true">
    <div class="card">
      <div class="card-header" role="tab" id="headingOne">
        <h5 class="mb-0">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="fa fa-unsorted" aria-hidden="true"></i> Aktywne rezerwacje
          </a>
        </h5>
      </div>

      <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-block">
          <ul class="list-group">
            <?php
            $db = Baza::dajDB();
            $zap = $db->query("SELECT `id`,`data` FROM `rezerwacje` WHERE id_uzytkownika = ".$Uzytkownik->getId()." AND `data` >= NOW() AND potwierdzenie = 1");
            $ile = false;
            while($tab = $zap->fetch()){
              $ile = true;
              echo '
              <li class="list-group-item">
                '.$tab['data'].'
                <a href="?page=rezerwacje&s2='.$tab['id'].'" class="btn btn-sm btn-outline-danger mx-2">Anuluj <i class="fa fa-times"></i></a>
              </li>';
            }
            if (!$ile) {
              echo '
              <li class="list-group-item">
                <strong>Brak aktywnych rezerwacji</strong>
              </li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" role="tab" id="headingTwo">
        <h5 class="mb-0">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <i class="fa fa-unsorted" aria-hidden="true"></i> Nieaktywne Rezerwacje
          </a>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="card-block">
          <ul class="list-group">
            <?php
            $db = Baza::dajDB();
            $zap = $db->query("SELECT `id`,`data` FROM `rezerwacje` WHERE id_uzytkownika = ".$Uzytkownik->getId()." AND `data` >= NOW() AND potwierdzenie = 0");
            $ile = false;
            while($tab = $zap->fetch()){
              $ile = true;
              echo '
              <li class="list-group-item">
                '.$tab['data'].'
                <a href="?page=rezerwacje&s2='.$tab['id'].'" class="btn btn-sm btn-outline-warning mx-2">Anuluj <i class="fa fa-times"></i></a>
              </li>';
            }
            if (!$ile) {
              echo '
              <li class="list-group-item">
                <strong>Brak rezerwacji niepotwierdzonych</strong>
              </li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" role="tab" id="headingThree">
        <h5 class="mb-0">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <i class="fa fa-unsorted" aria-hidden="true"></i> Historia rezerwacji
          </a>
        </h5>
      </div>
      <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="card-block">
          <ul class="list-group">
            <?php
            $db = Baza::dajDB();
            $zap = $db->query("SELECT `id`,`data` FROM `rezerwacje` WHERE id_uzytkownika = ".$Uzytkownik->getId()." AND `data` <= NOW() AND potwierdzenie = 1 LIMIT 10");
            $ile = false;
            while($tab = $zap->fetch()){
              $ile = true;
              echo '
              <li class="list-group-item">
                <small class="text-muted">'.$tab['data'].'</small>
              </li>';
            }
            if (!$ile) {
              echo '
              <li class="list-group-item">
                <strong>Brak historii rezerwacji</strong>
              </li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>