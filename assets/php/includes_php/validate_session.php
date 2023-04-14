<?php

if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['usuario'])) {
  header('Location: /login.php');
  $_SESSION['error'] = 'Você não tem permissão para acessar esta página.';
  exit;
}


