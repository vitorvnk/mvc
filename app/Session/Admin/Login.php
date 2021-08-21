<?php
    namespace App\Session\Admin;

    class Login{
        //Repsonsável por iniciar a sessao
        private static function init(){
            //Verifica se a sessão não está ativa
            if(session_status() != PHP_SESSION_ACTIVE){
                session_start();
            }

        } 

        //Responsável por criar o login do usuário
        public static function login($obUser){
            //Inicia a sessão
            self::init();

            //Define a sessão do usuário
            $_SESSION['admin']['usuario'] = [
                'id' => $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email
            ];

            //Sucesso
            return true;
        }

        //Verifica se o usuário está logado
        public static function isLogged(){
            //Inicia a sessão
            self::init();

            //retorna a veriicação
            return isset($_SESSION['admin']['usuario']['id']);
        }

        //Destroi o login
        public static function logout(){
            //Inicia a sessão
            self::init();

            //Desloga o usuario
            unset($_SESSION['admin']['usuario']);

            //Sucess
            return true;
        }
    }

?>