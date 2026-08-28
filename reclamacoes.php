<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/conexao.php';
require_once 'includes/header.php';

$mensagem_sucesso = '';
$mensagem_erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $texto = trim($_POST['mensagem'] ?? '');

    if ($texto === '') {
        $mensagem_erro = 'Escreva sua reclamação antes de enviar.';
    } else {

        $sql = "INSERT INTO reclamacoes
                (
                    usuario_id,
                    usuario_nome,
                    mensagem
                )
                VALUES
                (
                    :usuario_id,
                    :usuario_nome,
                    :mensagem
                )";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            ':usuario_id'   => $_SESSION['usuario_id'],
            ':usuario_nome' => $_SESSION['usuario_nome'],
            ':mensagem'     => $texto,
        ]);

        $mensagem_sucesso = 'Reclamação enviada com sucesso!';
    }
}

$sql = "SELECT mensagem, data_criacao
        FROM reclamacoes
        WHERE usuario_id = :usuario_id
        ORDER BY data_criacao DESC";

$stmt = $conexao->prepare($sql);
$stmt->execute([':usuario_id' => $_SESSION['usuario_id']]);
$minhas_reclamacoes = $stmt->fetchAll();

?>

<main>

    <section class="cadastro-section">

        <div class="section-title">

            <span>VIBE NIGHT</span>

            <h2>Enviar Reclamação</h2>

            <p>
                Conte pra gente o que aconteceu.
            </p>

        </div>

        <div class="form-container">

            <?php if ($mensagem_sucesso): ?>
                <div class="mensagem-sucesso"><?= htmlspecialchars($mensagem_sucesso) ?></div>
            <?php endif; ?>

            <?php if ($mensagem_erro): ?>
                <div class="mensagem-erro"><?= htmlspecialchars($mensagem_erro) ?></div>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">

                    <label for="mensagem">
                        Sua reclamação
                    </label>

                    <textarea
                        name="mensagem"
                        id="mensagem"
                        rows="5"
                        placeholder="Conte o que aconteceu..."
                    ></textarea>

                </div>

                <button type="submit" class="btn">
                    Enviar
                </button>

            </form>

        </div>

        <?php if (count($minhas_reclamacoes) > 0): ?>

            <div class="form-container" style="margin-top: 30px;">

                <h2 style="margin-bottom: 20px;">
                    Minhas reclamações
                </h2>

                <?php foreach ($minhas_reclamacoes as $r): ?>

                    <div class="reclamacao-item">

                        <p>
                            <?= nl2br(htmlspecialchars($r['mensagem'])) ?>
                        </p>

                        <span class="reclamacao-data">
                            <?= date('d/m/Y H:i', strtotime($r['data_criacao'])) ?>
                        </span>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>