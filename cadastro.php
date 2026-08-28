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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $artista = trim($_POST['artista']);
    $preco_pista = $_POST['preco_pista'];
    $preco_vip = $_POST['preco_vip'];
    $preco_camarote = $_POST['preco_camarote'];
    $ingressos_disponiveis = $_POST['ingressos_disponiveis'];


    $sql = "INSERT INTO eventos
            (
                nome,
                artista,
                preco_pista,
                preco_vip,
                preco_camarote,
                ingressos_disponiveis
            )
            VALUES
            (
                :nome,
                :artista,
                :preco_pista,
                :preco_vip,
                :preco_camarote,
                :ingressos_disponiveis
            )";


    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':artista' => $artista,
        ':preco_pista' => $preco_pista,
        ':preco_vip' => $preco_vip,
        ':preco_camarote' => $preco_camarote,
        ':ingressos_disponiveis' => $ingressos_disponiveis
    ]);


    header('Location: index.php');
    exit;
}

?>

<main>

    <section class="cadastro-section">

        <div class="section-title">

            <span>VIBE NIGHT</span>

            <h2>Cadastrar Evento</h2>

            <p>
                Cadastre os próximos eventos da Vibe Night.
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
                        placeholder="Ex: Vibe Night Festival"
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
                        placeholder="Ex: DJ Alok"
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
                        placeholder="Ex: 80.00"
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
                        placeholder="Ex: 150.00"
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
                        placeholder="Ex: 250.00"
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
                        placeholder="Ex: 500"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Cadastrar Evento
                </button>

            </form>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>