<?php
require 'autoload.php';

use Desafio\Dominio\Modelo\Evento;
use Desafio\Dominio\Modelo\Pessoa as ModeloPessoa;
use Desafio\InfraEstrutura\Persistencia\CriaConexao;
use Desafio\InfraEstrutura\Repositorio\PdoRepoPessoa;
use Desafio\InfraEstrutura\Repositorio\PdoRepoEvent;

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['sobreNome'])) {
        echo "Prencha todos os campos";
    } else {
        $repoPessoa = new PdoRepoPessoa(CriaConexao::criarConexao());
        // Cria uma instância de Pessoa com os dados do formulário
        $pessoaExistente = $repoPessoa->buscarPessoaPorNome($_POST['nome'], $_POST['sobreNome']);
        if ($pessoaExistente !== null) {
            $pessoa = $pessoaExistente;
        } else {
            $pessoa = new ModeloPessoa(null, $_POST['nome'], $_POST['sobreNome']);
            $repoPessoa->salvar($pessoa);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio Treinamento</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Formulário Pessoa</h2>
        <form id="Cadastropessoa" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="sobreNome">Sobre Nome:</label>
                <input type="text" class="form-control" id="sobreNome" name="sobreNome" placeholder="Digite seu Sobre Nome" required>
            </div>
            <button type="submit" class="btn btn-primary" value="Enviar">Enviar</button>
        </form>
    </div>
    
    <div class="container mt-5">
        <h2>Cadastro de Salas de Evento</h2>
        <!-- Botão que abre o modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCadastroSala">
            Cadastrar Nova Sala
        </button>
        <!-- Modal de cadastro de sala -->
        <div class="modal fade" id="modalCadastroSala" tabindex="-1" role="dialog" aria-labelledby="modalCadastroSalaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroSalaLabel">Cadastro de Nova Sala</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de cadastro de sala -->
                        <form method="POST">
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (empty($_POST['nomeSala']) || empty($_POST['lotacaoEvento'])) {
                                        echo "Prencha todos os campos.";
                                    } else {
                                        $repoEvent = new PdoRepoEvent(CriaConexao::criarConexao());
                                        $EventoExistente = $repoEvent->buscarEventoPorNome($_POST['nomeSala']);
                                        if ($EventoExistente !== null) {
                                            $evento = $EventoExistente;
                                        } else {
                                            $evento = new Evento(null, $_POST['nomeSala'], $_POST['lotacaoEvento'], intval($_POST['idPessoaEvento']));
                                            $repoEvent->salvar($evento);
                                        }
                                    }
                                }
                            ?>
                            <div class="form-group">
                                <label for="idPessoaEvento">Seu Nome:</label>
                                <select class="form-control" id="idPessoaEvento" name="idPessoaEvento" required>
                                    <?php
                                        $nomePessoasEvent = $repoPessoa->NomesPessoas();
                                        foreach ($nomePessoasEvent as $nomePessoa) {
                                            echo "<option value='".$nomePessoa['nome']."'>" . $nomePessoa['nome'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nomeSala">Nome da Sala:</label>
                                <input type="text" class="form-control" id="nomeSala" name="nomeSala" placeholder="Digite o nome da sala">
                            </div>
                            <div class="form-group">
                                <label for="lotacaoEvento">Lotação da Sala:</label>
                                <input type="number" class="form-control" id="lotacaoEvento" name="lotacaoEvento" placeholder="Digite a lotação da sala" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary" value="cadastrarEvent">Cadastrar Sala</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Cadastro de Espaços de Café</h2>
        <!-- Botão que abre o modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCadastroCafe">
            Cadastrar Novo Espaço de Café
        </button>

        <!-- Modal de cadastro de espaço de café -->
        <div class="modal fade" id="modalCadastroCafe" tabindex="-1" role="dialog" aria-labelledby="modalCadastroCafeLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroCafeLabel">Cadastro de Novo Espaço de Café</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de cadastro de espaço de café -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="selectPessoaCafe">Seu Nome:</label>
                                <select class="form-control" id="pessoaCafe" name="pessoaCafe">
                                    <?php
                                        $nomePessoasCafe = $repoPessoa->NomesPessoas();
                                        foreach ($nomePessoasCafe as $nomePessoa) {
                                            echo "<option value='" . $nomePessoa['nome'] . "'>" . $nomePessoa['nome'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nomeCafe">Nome do Espaço de Café:</label>
                                <input type="text" class="form-control" id="nomeCafe" name="nomeCafe" placeholder="Digite o nome do espaço de café">
                            </div>
                            <div class="form-group">
                                <label for="lotacaoCafe">Lotação do Espaço de Café:</label>
                                <input type="number" class="form-control" id="lotacaoCafe" name="lotacaoCafe" placeholder="Digite a lotação da sala" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary" value="cadastrarCafe">Cadastrar Espaço de Café</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

   
</body>
</html>

