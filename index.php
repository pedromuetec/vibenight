<?php

session_start();

require_once 'config/conexao.php';
require_once 'includes/header.php';

$sql = "SELECT * FROM eventos";

$stmt = $conexao->prepare($sql);
$stmt->execute();

$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>

    <section class="hero">

        <div class="hero-content">

            <span class="hero-subtitle">
                VIBE NIGHT
            </span>

            <h1>
                A energia da noite
                <span>começa aqui.</span>
            </h1>

            <p>
                Música, artistas, experiências e os melhores
                eventos em um só lugar.
            </p>

            <a href="#eventos" class="btn hero-btn">
                Ver eventos
            </a>

        </div>

    </section>


    <section class="eventos-section" id="eventos">

        <div class="section-title">

            <span>PROGRAMAÇÃO</span>

            <h2>Próximos Eventos</h2>

            <p>
                Prepare-se para viver experiências inesquecíveis.
            </p>

        </div>


        <div class="container">

            <?php foreach ($eventos as $evento): ?>

                <div class="evento-card">

                    <div class="card-content">

                        <span class="card-label">
                            VIBE NIGHT EVENT
                        </span>

                        <h3>
                            <?= htmlspecialchars($evento['nome']) ?>
                        </h3>


                        <div class="evento-info">

                            <p>
                                <strong>Artista</strong>

                                <span>
                                    <?= htmlspecialchars($evento['artista']) ?>
                                </span>
                            </p>

                            <p>
                                <strong>Pista</strong>

                                <span>
                                    R$
                                    <?= number_format(
                                        $evento['preco_pista'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </span>
                            </p>

                            <p>
                                <strong>Área VIP</strong>

                                <span>
                                    R$
                                    <?= number_format(
                                        $evento['preco_vip'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </span>
                            </p>

                            <p>
                                <strong>Camarote</strong>

                                <span>
                                    R$
                                    <?= number_format(
                                        $evento['preco_camarote'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </span>
                            </p>

                            <p>
                                <strong>Ingressos disponíveis</strong>

                                <span>
                                    <?= htmlspecialchars(
                                        $evento['ingressos_disponiveis']
                                    ) ?>
                                </span>
                            </p>

                        </div>


                        <?php if (
                            isset($_SESSION['usuario_tipo']) &&
                            $_SESSION['usuario_tipo'] === 'admin'
                        ): ?>

                            <div class="card-buttons">

                                <a
                                    class="btn"
                                    href="editar.php?id=<?= $evento['id'] ?>"
                                >
                                    Editar evento
                                </a>

                                <a
                                    class="btn excluir"
                                    href="excluir.php?id=<?= $evento['id'] ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir este evento?')"
                                >
                                    Excluir
                                </a>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

</main>

<?php require_once 'includes/footer.php'; ?>