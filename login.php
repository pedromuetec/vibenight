<?php

session_start();

require_once 'config/conexao.php';

$erro = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuarios WHERE email = :email";

    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        ':email' => $email
    ]);


    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


    if (
        $usuario &&
        password_verify($senha, $usuario['senha'])
    ) {

        $_SESSION['usuario_id'] = $usuario['id'];

        $_SESSION['usuario_nome'] = $usuario['nome'];

        $_SESSION['usuario_tipo'] = $usuario['tipo'];


        header('Location: index.php');

        exit;

    } else {

        $erro = 'E-mail ou senha incorretos.';

    }
}


require_once 'includes/header.php';

?>

<main>

    <section class="login-section">

        <div class="section-title">

            <span>VIBE NIGHT</span>

            <h2>Entrar</h2>

            <p>
                Entre na sua conta para continuar.
            </p>

        </div>


        <div class="form-container">

            <?php if ($erro): ?>

                <div class="mensagem-erro">

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="seu@email.com"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Entrar
                </button>

            </form>


            <p class="login-cadastro">

                Ainda não possui uma conta?

                <a href="cadastro_usuario.php">
                    Criar conta
                </a>

            </p>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>