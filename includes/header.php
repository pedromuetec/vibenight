Aqui está o includes/header.php completo, já com tudo integrado:

php
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Vibe Night</title>

    <link rel="stylesheet" href="/vibenight/css/style.css">

</head>

<body>

<header>

    <div class="logo">

        <a href="index.php">
            VIBE NIGHT
        </a>

    </div>

    <nav>

        <a href="index.php">
            Eventos
        </a>

        <a href="sobre.php">
            Sobre Nós
        </a>

        <?php if (isset($_SESSION['usuario_id'])): ?>

            <a href="reclamacoes.php">
                Reclamações
            </a>

        <?php endif; ?>

        <?php if (
            isset($_SESSION['usuario_tipo']) &&
            $_SESSION['usuario_tipo'] === 'admin'
        ): ?>

            <a href="cadastro.php">
                Cadastrar Evento
            </a>

            <a href="reclamacoes-admin.php">
                Ver Reclamações
            </a>

        <?php endif; ?>

        <?php if (isset($_SESSION['usuario_id'])): ?>

            <span class="usuario-logado">
                Olá,
                <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
            </span>

            <a href="logout.php">
                Sair
            </a>

        <?php else: ?>

            <a href="login.php">
                Entrar
            </a>

        <?php endif; ?>

    </nav>

</header>