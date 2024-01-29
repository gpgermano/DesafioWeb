<?php
    namespace Desafio\Dominio\Repositorio;

    use Desafio\Dominio\Modelo\Pessoa as ModeloPessoa;
    
    interface RepoPessoa {
        public function todasPessoas() : array;
        public function salvar(ModeloPessoa $pessoa) : bool;
        public function ler(ModeloPessoa $pessoa) : array;
        public function delete(ModeloPessoa $pessoa) : bool;
        public function NomesPessoas() : array;
    }