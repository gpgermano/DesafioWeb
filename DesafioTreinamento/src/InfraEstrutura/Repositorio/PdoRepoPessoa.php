<?php
    namespace Desafio\InfraEstrutura\Repositorio;

    use Desafio\Dominio\Modelo\Pessoa;
    use Desafio\Dominio\Repositorio\RepoPessoa;
    use PDO;

    class PdoRepoPessoa implements RepoPessoa
    {
        private PDO $conexao;

        public function __construct(PDO $conexao)
        {
            $this->conexao = $conexao;
        }

        private function createPessoa(Pessoa $pessoa) : bool 
        {
            $sql = "INSERT INTO pessoa (nome, sobreNome) values (:nome, :sobreNome);";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $pessoa->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':sobreNome', $pessoa->getSobreNome(), PDO::PARAM_STR);
            $sucess = $stmt->execute();
            if ($sucess) {
                $pessoa->setId($this->conexao->lastInsertId());
            }
            return $sucess;
        }

        public function buscarPessoaPorNome(string $nome, string $sobreNome): ?Pessoa
        {
            $sql = "SELECT * FROM pessoa WHERE nome = :nome AND sobreNome = :sobreNome LIMIT 1;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':sobreNome', $sobreNome, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result === false) {
                return null;
            }

            // Se encontrarmos a pessoa, retornamos um objeto Pessoa com os dados encontrados
            return new Pessoa($result['id'], $result['nome'], $result['sobreNome']);
        }

        public function ler(Pessoa $pessoa) : array 
        {
            $sql = "SELECT * FROM pessoa WHERE id = :id;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $pessoa->getId(), PDO::PARAM_INT);
            $stmt->execute();
            return $this->hidratarListaPessoa($stmt);
        }

        public function salvar(Pessoa $pessoa): bool
        {
            if ($pessoa->getId() === null) {
                return $this->createPessoa($pessoa);
            }
            return $this->updatePessoa($pessoa);
        }

        public function delete(Pessoa $pessoa) : bool 
        {
            $stmt = $this->conexao->prepare('DELETE FROM pessoa WHERE id = ?;');
            $stmt->bindValue(1, $pessoa->getId(), PDO::PARAM_INT);

            return $stmt->execute();
        }

        private function updatePessoa(Pessoa $pessoa): bool
        {
            $sql = "UPDATE pessoa SET nome = :nome, sobreNome = :sobreNome WHERE id = :id;";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $pessoa->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':sobreNome', $pessoa->getSobreNome(), PDO::PARAM_INT);
            $stmt->bindValue(':id', $pessoa->getId(), PDO::PARAM_INT);

            return $stmt->execute();
        }

        public function NomesPessoas() : array 
        {
            $sql = "SELECT id,nome FROM pessoa";   
            $stmt = $this->conexao->query($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarIdPessoaPorNome($nome) {
            $query = "SELECT id FROM pessoa WHERE nome = :nome";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($resultado) {
                return $resultado['id'];
            } else {
                return null;
            }
        }

        public function todasPessoas() : array 
        {
            $sql = "SELECT * FROM pessoa";
            $stmt = $this->conexao->query($sql);
            
            return $this->hidratarListaPessoa($stmt);
        }

        private function hidratarListaPessoa(\PDOStatement $stmt) : array 
        {
            $listaDadosPessoa = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $listaPessoa = [];
            echo '<table>'; 
            foreach ($listaDadosPessoa as $listaDadosPessoa) {
                $listaPessoa [] = new Pessoa (
                    $listaPessoa['id'],
                    $listaPessoa['nome'],
                    $listaPessoa['sobreNome']
                );
            }
            
            return $listaPessoa;
        }
        
    }