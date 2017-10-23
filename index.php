<?php
require 'service/functions.php';
require 'model/data.php';

if(isset($_SESSION['perso'])) {
  require 'controller/combat.php';
}
else {
  require 'controller/newperso.php';
}
