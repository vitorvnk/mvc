<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;
    use \App\Model\Entity\User;
    use \App\Session\Admin\Login as SessionAdminLogin;

    class Login extends Page{
        //Metodo responsável por retornar a renderização da pagina de Login
        public static function getLogin($request,$errorMessage = null){
            $status = !is_null($errorMessage) ? View::render('admin/login/status',[
                'mensagem' => $errorMessage
            ]) : '';

            //Conteudo da Página de Login
            $content = View::render('admin/login',[
                'status' => $status
            ]);

            //Retorna a Página completa
            return parent::getPage('Login', $content);
        }

        //metodo responsável por definir o login do usuário
        public static function setLogin($request){
            //POST Vars
            $postVars = $request->getPostVars();
            $email = $postVars['email'] ?? '';
            $senha = $postVars['senha'] ?? '';

            //Busca usuáro pelo e-mail
            $obUser = User::getUserByEmail($email);
            if(!$obUser instanceof User) {
                return self::getLogin($request,'E-mail ou Senha Inválidos');
            }

            //Verifica a senha do usuário
            if(!password_verify($senha,$obUser->senha)){
                return self::getLogin($request,'E-mail ou Senha Inválidos');
            }

            //Cria a sessão de Login
            SessionAdminLogin::login($obUser);

            //Redireciona o usuário para a home do admin
            $request->getRouter()->redirect('/admin');
        }

        //Metodo responsável por deslogar o usuário
        public static function setLogout($request){
            //Destroi a sessão de Login
            SessionAdminLogin::logout();

            //Redireciona o usuário para a a tela de login
            $request->getRouter()->redirect('/admin/login');



        }

    }


?>