<?php
    namespace App\Model\Entity;
    use WilliamCosta\DatabaseManager\Database;

    class Testmon{
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
            //Define a database
            $this->data = date('Y-m-d H:i:s');

            //Insere depoimentos no banco de dados
            $this->id = (new Database('depoimentos'))->insert([
                'nome' => $this->nome,
                'mensagem' => $this->mensagem,
                'data' => $this->data
            ]);
            //Sucesso ao cadastrar
            return true;
        }

        public static function getTestimonies($where = null, $order = null, $limit=null, $fields = '*'){
            return (new Database('depoimentos'))->select($where, $order,$limit, $fields);
        }




    }

?>