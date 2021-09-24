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
            date_default_timezone_set('America/Sao_Paulo');
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

        //metodo responsável por retornar o depoimento com base ao ID
        public static function getTestimonyById($id){
            return self::getTestimonies('id = '.$id)->fetchObject(self::class);
        }

        //Exclui dos dados do banco
        public function excluir(){
            //Exclui depoimentos no banco de dados
            return (new Database('depoimentos'))->delete('id = '.$this->id);
        }

        //Metodo responsável por atualizar os dados no banco
        public function atualizar() {
            return (new Database('depoimentos'))->update('id = '.$this->id,[
                'nome' => $this->nome,
                'mensagem' => $this->mensagem
            ]);
        }

    }

?>