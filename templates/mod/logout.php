<?php
//czyścimy dane sesji
$_SESSION = NULL;
//niszczymy sesję
session_destroy();
reload('');
?>