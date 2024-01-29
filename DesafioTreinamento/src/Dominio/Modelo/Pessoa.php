<?php
    namespace Desafio\Dominio\Modelo;
    require "autoload.php";
    class Pessoa
    {
        public ?int $id;
        public string $nome;
        public string $sobreNome;

        protected static int $numeroDePessoas = 0;


        public function __construct(?int $id,string $nome,string $sobreNome)
        {
            $this->id = $id;
            $this->nome = $nome;
            $this->sobreNome = $sobreNome;
        }

        //GETTERS
        public function getId() : ?int 
        {   
            return $this->id;
        }
        public static function getNumDePessoas() : int 
        {
            return self::$numeroDePessoas;    
        }
        
        public function getNome() : string 
        {   
            return $this->nome;
        }

        public function getSobreNome() : string
        {   
            return $this->sobreNome;
        }

        //SETTERS

        public function setId(?int $id) : void 
        {
            $this->id = $id;
        }

        public function setNome(string $nome) : void 
        {
            $this->nome = $nome;
        }
        public function setSobreNome(string $sobreNome) : void 
        {
            $this->sobreNome = $sobreNome;
        }

        public function __toString(): string
        {
            return "<p>Nome: ".$this->nome.
            "<br>Sobrenome: ".$this->sobreNome;
        }

    }
    