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
require_once 'includes/header.php';

// Excluir reclamação
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['excluir_id'])
) {

    $sql = "DELETE FROM reclamacoes WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':id' => $_POST['excluir_id']]);

    header('Location: reclamacoes-admin.php');
    exit;
}

$sql = "SELECT id, usuario_nome, mensagem, data_criacao
        FROM reclamacoes
        ORDER BY data_criacao DESC";

$stmt = $conexao->query($sql);
$reclamacoes = $stmt->fetchAll();

?>

<main>

    <section class="eventos-section">

        <div class="section-title">

            <span>PAINEL ADMIN</span>

            <h2>Reclamações recebidas</h2>

        </div>

        <div class="container">

            <?php if (count($reclamacoes) === 0): ?>

                <p style="color: #999; text-align: center;">
                    Nenhuma reclamação registrada até o momento.
                </p>

            <?php else: ?>

                <?php foreach ($reclamacoes as $r): ?>

                    <div class="evento-card">

                        <div class="card-content">

                            <span class="card-label">
                                <?= htmlspecialchars($r['usuario_nome']) ?>
                            </span>

                            <p style="margin-top: 12px; color: #ccc;">
                                <?= nl2br(htmlspecialchars($r['mensagem'])) ?>
                            </p>

                            <p style="margin-top: 15px; color: #666; font-size: 12px;">
                                <?= date('d/m/Y H:i', strtotime($r['data_criacao'])) ?>
                            </p>

                            <form
                                method="POST"
                                onsubmit="return confirm('Marcar como resolvida e excluir esta reclamação?');"
                            >

                                <input
                                    type="hidden"
                                    name="excluir_id"
                                    value="<?= $r['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn excluir"
                                >
                                    Excluir
                                </button>

                            </form>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>