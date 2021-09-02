<?php
    namespace App\Model\Entity;
    use WilliamCosta\DatabaseManager\Database;

    class User{
        //ID do depoimento
        public $id;
        //Nome do usuário
        public $nome;
        //Email do usuário
        public $email;
        //Senha do usuário
        public $senha;

        //Retorna um usuário com base no seu e-mail
        public static function getUserByEmail($email){
            return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
        }

        //Retorna os Usuários
        public static function getUsers($where = null, $order = null, $limit=null, $fields = '*'){
            return (new Database('usuarios'))->select($where, $order,$limit, $fields);
        }

        //Método responsável por cadastrar 
        public function cadastrar(){
            //Insere depoimentos no banco de dados
            $this->id = (new Database('usuarios'))->insert([
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha
            ]);

            //Sucesso ao cadastrar
            return true;
        }

        //Metodo responsável por atualizar os dados no banco
        public function atualizar() {
            return (new Database('usuarios'))->update('id = '.$this->id,[
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha
            ]);
        }

        //Exclui dos dados do banco
        public function excluir(){
            //Exclui depoimentos no banco de dados
            return (new Database('usuarios'))->delete('id = '.$this->id);
        }

        //metodo responsável por retornar o usuário com base ao ID
        public static function getUserById($id){
            return self::getUsers('id = '.$id)->fetchObject(self::class);
        }

        









    }



?>