<?php
include("config.php");
$dbd = $config['db'];

//$dbd ist array mit Konfig-Datenbank-Daten

$db = mysqli_connect($dbd["host"], $dbd["user"], $dbd["pass"], $dbd["name"]);
$db->set_charset("utf8");
//$db ist die Datenbankverbindung
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
?>
