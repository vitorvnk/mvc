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













    }



?>