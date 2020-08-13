<?php
require_once('connect.php');
$sql = "SELECT a.* FROM courses a ";
if ($_REQUEST['nomeFiltro']){
    $sql .= "WHERE a.name LIKE '%".$_REQUEST['nomeFiltro']."%' ";
    $where = 1;
}
$sql .= "ORDER BY a.id ASC";
$query = mysqli_query($con, $sql);
$arquivo = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<cursos>\r\n";
if (mysqli_num_rows($query)){
    while($value = mysqli_fetch_object($query)){
        $arquivo .= "<curso>\r\n<codigo>".$value->id."</codigo>\r\n<nome>".utf8_encode($value->name)."</nome>\r\n</curso>\r\n";
    }
}
$arquivo .= "</cursos>";
$fp = fopen(DIRETORIO_SITE."cursos.xml", "w+");
fwrite($fp, $arquivo);
fclose($fp);
$sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('Exportou os clientes do site', '".$_REQUEST['idUser']."', now(), now())";
mysqli_query($con, $sql);


$fp = fopen(DIRETORIO_SITE."cursos.xml", "r");
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename=cursos'.date('Y-m-d-H-i-s').'.xml');

while(!feof ($fp)) {

    echo fgets($fp); //LENDO A LINHA
}
fclose($fp);
unlink(DIRETORIO_SITE."clientes.csv");
?>
