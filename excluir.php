<?php

session_start();

if (
    !isset($_SESSION['usuario_tipo']) ||
    $_SESSION['usuario_tipo'] !== 'admin'
) {
    header('Location: index.php');
    exit;
}


require_once 'config/conexao.php';


if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}


$id = $_GET['id'];


$sql = "DELETE FROM eventos WHERE id = :id";

$stmt = $conexao->prepare($sql);

$stmt->execute([
    ':id' => $id
]);


header('Location: index.php');

exit;