<?php   
    namespace Desafio\InfraEstrutura\Repositorio;

    use Desafio\Dominio\Modelo\Evento;
    use Desafio\Dominio\Repositorio\RepoEvent;
    use Desafio\Dominio\Modelo\Pessoa;

    use PDO;

    class PdoRepoEvent implements RepoEvent
    {
        private PDO $conexao;

        public function __construct(PDO $conexao)
        {
            $this->conexao = $conexao;
        }


        private function createEvent(Evento $evento) : bool 
        {
            $sql = "INSERT INTO evento (nome, lotacao) values (:nome, :lotacao);";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $evento->getNomeEvento(), PDO::PARAM_STR);
            $stmt->bindValue(':lotacao', $evento->getLotacaoEvento(), PDO::PARAM_INT);
            $sucess = $stmt->execute();
            if ($sucess) {
                $evento->setIdEvento($this->conexao->lastInsertId());
            }

            return $sucess;
        }

        public function ler(Evento $evento) : array 
        {
            $sql = "SELECT * FROM evento WHERE id = :id;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $evento->getIdEvento(), PDO::PARAM_INT);
            $stmt->execute();
            return $this->hidratarListaEvento($stmt);
        }

        public function salvar(Evento $evento): bool
        {
            if ($this->createEvent($evento)) {
                return true;
            }
            return false;
        }

        public function delete(Evento $evento) : bool 
        {
            $stmt = $this->conexao->prepare('DELETE FROM evento WHERE id = ?;');
            $stmt->bindValue(1, $evento->getIdEvento(), PDO::PARAM_INT);

            return $stmt->execute();
        }
        
        public function todosEeventos() : array 
        {
            $sql = "SELECT * FROM evento";
            $stmt = $this->conexao->query($sql);
            
            return $this->hidratarListaEvento($stmt);
        }

        private function updateEvento(Evento $evento): bool
        {
            $sql = "UPDATE evento SET nome = :nome, lotacao = :lotacao WHERE id = :id;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $evento->getNomeEvento(), PDO::PARAM_STR);
            $stmt->bindValue(':lotacao', $evento->getLotacaoEvento(), PDO::PARAM_INT);
            $stmt->bindValue(':id', $evento->getIdEvento(), PDO::PARAM_INT);

            return $stmt->execute();
        }
        
        public function buscarEventoPorNome(string $nome): ?Evento
        {
            $sql = "SELECT * FROM evento WHERE nome = :nome LIMIT 1;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result === false) {
                return null;
            }

            // Se encontrarmos a pessoa, retornamos um objeto Pessoa com os dados encontrados
            return new evento ($result['id'], $result['nome'], $result['sobreNome'], $result['idPessoaEvento']);
        }

        public function todasPessoasComEventoCad() : array 
        {
            $sql = "SELECT * FROM pessoa JOIN evento on id = idPessoaEvento";
            $stmt = $this->conexao->query($sql);
            
            return $this->hidratarListaEvento($stmt);;
        }

        private function hidratarListaEvento(\PDOStatement $stmt): array 
        {
            $listaDadosEventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $listaEventos = [];

            foreach ($listaDadosEventos as $dadosEvento) {
                $evento = new Evento(
                    $dadosEvento['id'],
                    $dadosEvento['nome'],
                    $dadosEvento['lotacao'],
                    $dadosEvento['idPessoaEvento']
                );
                $listaEventos[] = $evento;
            }
            
            return $listaEventos;
        }


    }
    
