<?php
    namespace Desafio\Dominio\Modelo;
    require "autoload.php";
    class Evento 
    {
        public ?int $idEventos;
        public string $nomeEvento;
        public int $lotacaoEvento;
        public ?int $idpessoaEvent;

        protected static int $numeroDeEventos = 0;

        public function __construct(?int $idEventos,string $nomeEvento,int $lotacaoEvento, ?int $idpessoaEvent)
        {
            $this->idEventos = $idEventos;
            $this->nomeEvento = $nomeEvento;
            $this->lotacaoEvento = $lotacaoEvento;
            $this->idpessoaEvent = $idpessoaEvent;
        }

        //GETTERS
        public function getIdEvento() : ?int 
        {
            return $this->idEventos;    
        }
        public static function getNumDeEventos() : int 
        {
            return self::$numeroDeEventos;    
        }
        public function getNomeEvento() : string 
        {
            return $this->nomeEvento;    
        }
        
        public function getLotacaoEvento() : int 
        {
            return $this->lotacaoEvento;    
        }

        public function getIdpessoaEvent() : ?int 
        {
            return $this->idpessoaEvent;    
        }

        //SETTERS
        public function setIdEvento(?int $idEventos) : void 
        {
            $this->idEventos = $idEventos;
        }

        public function setNomeEvento(string $nomeEvento) : void 
        {
            $this->nomeEvento = $nomeEvento;
        }

        public function setlotacaoEvento(int $lotacaoEvento) : void 
        {
            $this->lotacaoEvento = $lotacaoEvento;
        }

        public function setidPessoaEvent(?int $idpessoaEvent) : void 
        {
            $this->idpessoaEvent = $idpessoaEvent;
        }

        public function __toString(): string
        {
            return "<p>Nome: ".$this->nomeEvento.
            "<br>lotacao: ".$this->lotacaoEvento;
        }
           
    }