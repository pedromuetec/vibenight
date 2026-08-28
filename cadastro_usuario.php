<?php

session_start();

require_once 'config/conexao.php';

$erro = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];


    if (strlen($senha) < 6) {

        $erro = 'A senha deve possuir pelo menos 6 caracteres.';

    } else {

        $sql = "SELECT id
                FROM usuarios
                WHERE email = :email";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);


        if ($stmt->fetch()) {

            $erro = 'Este e-mail já está cadastrado.';

        } else {

            $senha_hash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );


            $sql = "INSERT INTO usuarios
                    (
                        nome,
                        email,
                        senha,
                        tipo
                    )
                    VALUES
                    (
                        :nome,
                        :email,
                        :senha,
                        'cliente'
                    )";


            $stmt = $conexao->prepare($sql);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senha_hash
            ]);


            header('Location: login.php');

            exit;
        }
    }
}


require_once 'includes/header.php';

?>

<main>

    <section class="cadastro-section">

        <div class="section-title">

            <span>VIBE NIGHT</span>

            <h2>Criar conta</h2>

            <p>
                Crie sua conta para acompanhar os eventos.
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

                    <label for="nome">
                        Nome
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        placeholder="Seu nome"
                        required
                    >

                </div>


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
                        placeholder="Mínimo de 6 caracteres"
                        minlength="6"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Criar conta
                </button>

            </form>


            <p class="login-cadastro">

                Já possui uma conta?

                <a href="login.php">
                    Entrar
                </a>

            </p>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>