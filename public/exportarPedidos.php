<?php
require_once('connect.php');

$sql = "SELECT DISTINCT a.id, a.*, b.name AS nomeStatus, b.sigla, c.name AS nomeCliente 
                        FROM requests a 
                        INNER JOIN requests_statuses b ON (a.status = b.id) 
                        INNER JOIN clients c ON (a.client = c.id) 
                        LEFT JOIN requests_items d ON (a.id = d.request) ";
if ($_REQUEST['idFiltro']) {
    $sql .= "WHERE a.id LIKE '%" . $_REQUEST['idFiltro'] . "%' ";
    $where = 1;
}
if ($_REQUEST['dataFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "a.created_at LIKE '%" . $_REQUEST['dataFiltro'] . "%' ";
    $where = 1;
}
if ($_REQUEST['formaPagamentoFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "a.paymentMethod = '" . $_REQUEST['formaPagamentoFiltro'] . "' ";
    $where = 1;
}
if ($_REQUEST['statusFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "a.status = '" . $_REQUEST['statusFiltro'] . "' ";
    $where = 1;
}
if ($_REQUEST['nomeFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "c.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
    $where = 1;
}
if ($_REQUEST['emailFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "c.email LIKE '%" . $_REQUEST['emailFiltro'] . "%' ";
    $where = 1;
}
if ($_REQUEST['nomeProdutoFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "d.name LIKE '%" . $_REQUEST['nomeProdutoFiltro'] . "%' ";
    $where = 1;
}
if ($_REQUEST['idProdutoFiltro']) {
    if ($where){
        $sql .= "AND ";
    }
    else{
        $sql .= "WHERE ";
    }
    $sql .= "d.id = '" . $_REQUEST['idProdutoFiltro'] . "' ";
    $where = 1;
}
$sql .= "ORDER BY a.id DESC";
$query = mysqli_query($con, $sql);
$arquivo = utf8_decode('ID;Nome;Email')."\r\n";
if (mysqli_num_rows($query)){
    while($value = mysqli_fetch_object($query)){
        $arquivo .= utf8_decode($value->id).";".$value->name.";".$value->email."\r\n";
    }
}
$sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('Exportou os pedidos do Site', '".$_REQUEST['idUser']."', now(), now())";
mysqli_query($con, $sql);
$fp = fopen(DIRETORIO_SITE."pedidos.csv", "w+");
fwrite($fp, $arquivo);
fclose($fp);


$fp = fopen(DIRETORIO_SITE."pedidos.csv", "r");
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename=pedidos'.date('Y-m-d-H-i-s').'.csv');

while(!feof ($fp)) {

    echo fgets($fp); //LENDO A LINHA
}
fclose($fp);
unlink(DIRETORIO_SITE."pedidos.csv");
?>
