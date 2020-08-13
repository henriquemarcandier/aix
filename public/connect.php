<?php
ini_set('display_errors', 'off');
session_start();
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');
$url = "http://localhost/aix/public/";
$url_site = "http://localhost/aix/public/";
$diretorio_site = "C:/xampp/htdocs/aix/";
$diretorio = "C:/xampp/htdocs/aix/public/";
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "aix";
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
define("URL", $url);
define("URL_SITE", $url_site);
define("DIRETORIO_SITE", $diretorio_site);
define("DIRETORIO", $diretorio);
?>
