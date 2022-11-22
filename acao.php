<?php
include_once "Cripto.php";

$cripto = new Cripto;
$cripto->Database();

if ($_GET['acao'] == 'adicionar') {
    $result = $cripto->store($_REQUEST);
    if ($result) echo $result;
}

if ($_GET['acao'] == 'alterar') {
    $result = $cripto->update($_REQUEST);
    if ($result) echo $result;
}

if ($_GET['acao'] == 'remover') {
    $result = $cripto->destroy($_REQUEST);
    if ($result) echo $result;
}
