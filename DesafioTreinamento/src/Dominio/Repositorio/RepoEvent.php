<?php   
    namespace Desafio\Dominio\Repositorio;

    use Desafio\Dominio\Modelo\Evento;

    interface RepoEvent {
        public function todosEeventos() : array;
        public function salvar(Evento $evento): bool;
        public function delete(Evento $evento) : bool;
        public function todasPessoasComEventoCad() : array;
    }