<?php
    namespace App\Model\Entity;

    class Testimony{
        //ID do depoimento
        public $id;
        //Nome do usuário que fez o depoimento
        public $nome;
        //Mensagem do usuário
        public $mensagem;
        //Data de publicação
        public $data;

        //Método responsável por cadastrar a instância atual no banco de dados
        public function cadastrar(){
            echo "<pre>";
            print_r($this);
            echo "<pre>";
            exit;
        }
    }

?>