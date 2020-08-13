<?php
require_once('connect.php');
$sql = "SELECT * FROM newsletters ";
if ($_REQUEST['nomeFiltro']){
    $sql .= "WHERE name LIKE '%".$_REQUEST['nomeFiltro']."%' ";
    $where = 1;
}
if ($_REQUEST['emailFiltro']){
    $where = 1;
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "email LIKE '%".$_REQUEST['emailFiltro']."%'";
}
if ($_REQUEST['dataFiltro']){
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "created_at LIKE '".$_REQUEST['dataFiltro']."%'";
}
$sql .= "ORDER BY created_at DESC";
$query = mysqli_query($con, $sql);
$arquivo = utf8_decode('Data;Nome;Email')."\r\n";
if (mysqli_num_rows($query)){
    while($value = mysqli_fetch_object($query)){
        $arquivo .= utf8_decode($value->updated_at).";".$value->name.";".$value->email."\r\n";
    }
}
$sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('Exportou as assinaturas em newsletter', '".$_REQUEST['idUser']."', now(), now())";
mysqli_query($con, $sql);
$fp = fopen(DIRETORIO_SITE."newsletter.csv", "w+");
fwrite($fp, $arquivo);
fclose($fp);


$fp = fopen(DIRETORIO_SITE."newsletter.csv", "r");
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename=newsletter'.date('Y-m-d-H-i-s').'.csv');

while(!feof ($fp)) {

    echo fgets($fp); //LENDO A LINHA
}
fclose($fp);
unlink(DIRETORIO_SITE."newsletter.csv");
?>
