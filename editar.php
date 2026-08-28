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


if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}


$id = $_GET['id'];


$sql = "SELECT * FROM eventos WHERE id = :id";

$stmt = $conexao->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$evento = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$evento) {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $artista = trim($_POST['artista']);
    $preco_pista = $_POST['preco_pista'];
    $preco_vip = $_POST['preco_vip'];
    $preco_camarote = $_POST['preco_camarote'];
    $ingressos_disponiveis = $_POST['ingressos_disponiveis'];


    $sql = "UPDATE eventos SET

                nome = :nome,
                artista = :artista,
                preco_pista = :preco_pista,
                preco_vip = :preco_vip,
                preco_camarote = :preco_camarote,
                ingressos_disponiveis = :ingressos_disponiveis

            WHERE id = :id";


    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':artista' => $artista,
        ':preco_pista' => $preco_pista,
        ':preco_vip' => $preco_vip,
        ':preco_camarote' => $preco_camarote,
        ':ingressos_disponiveis' => $ingressos_disponiveis,
        ':id' => $id
    ]);


    header('Location: index.php');
    exit;
}

?>

<main>

    <section class="cadastro-section">

        <div class="section-title">

            <span>VIBE NIGHT</span>

            <h2>Editar Evento</h2>

            <p>
                Altere as informações do evento.
            </p>

        </div>


        <div class="form-container">

            <form method="POST">

                <div class="form-group">

                    <label for="nome">
                        Nome do evento
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($evento['nome']) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="artista">
                        Artista
                    </label>

                    <input
                        type="text"
                        id="artista"
                        name="artista"
                        value="<?= htmlspecialchars($evento['artista']) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="preco_pista">
                        Valor - Pista
                    </label>

                    <input
                        type="number"
                        id="preco_pista"
                        name="preco_pista"
                        step="0.01"
                        min="0"
                        value="<?= htmlspecialchars($evento['preco_pista']) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="preco_vip">
                        Valor - Área VIP
                    </label>

                    <input
                        type="number"
                        id="preco_vip"
                        name="preco_vip"
                        step="0.01"
                        min="0"
                        value="<?= htmlspecialchars($evento['preco_vip']) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="preco_camarote">
                        Valor - Camarote
                    </label>

                    <input
                        type="number"
                        id="preco_camarote"
                        name="preco_camarote"
                        step="0.01"
                        min="0"
                        value="<?= htmlspecialchars($evento['preco_camarote']) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="ingressos_disponiveis">
                        Quantidade de ingressos
                    </label>

                    <input
                        type="number"
                        id="ingressos_disponiveis"
                        name="ingressos_disponiveis"
                        min="1"
                        value="<?= htmlspecialchars($evento['ingressos_disponiveis']) ?>"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Salvar Alterações
                </button>

            </form>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>