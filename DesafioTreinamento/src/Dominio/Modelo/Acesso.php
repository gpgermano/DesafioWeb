<?php
    namespace Desafio\Dominio\Modelo;
    trait Acesso
    {
        public function __get(string $nomeAcesso){
            $metodo = 'get'.ucfirst($nomeAcesso);
            return $this->$metodo;
        }
    }