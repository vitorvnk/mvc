<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;
    use \App\Model\Entity\User as EntityUser;

    class Registro extends Page{
        //Retorna o formulário para o cadastro de um novo Usuário
        public static function getNewUser($request){
            //Conteudo do Formulário
            $content = View::render('admin/registro', [
                'title' => 'Cadastrar Usuários',
                'nome' => '',
                'email' => '',
                'status' => self::getStatus($request)
            ]);
        

            //Retorna a Página completa
            return parent::getPage('Registro', $content);
        }

        //Responsável por cadastrar um novo Usuário
        public static function setNewUser($request){
            //Post Vars
            $postVars = $request->getPostVars();
            $nome = $postVars['nome'] ?? '';
            $email = $postVars['email'] ?? '';
            $senha = $postVars['senha'] ?? '';

            //Valida o e-mail do usuário
            $obUser = EntityUser::getUserByEmail($email);

            if($obUser instanceof EntityUser){
                //Redireciona o usuário
                $request->getRouter()->redirect('/admin/registro?status=duplicated');
            }

            //Nova instancia de Usuário
            $obUser = new EntityUser;
            $obUser->nome = $nome;
            $obUser->email = $email;
            $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
            $obUser->cadastrar();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/registro?status=created');
        }

        //Retorna a mensagem de Status
        private static function getStatus($request){
            //Query queryParams
            $queryParams = $request->getQueryParams();

            //Status
            if(!isset($queryParams['status'])) return '';

            //Mensagens
            switch($queryParams['status']){
                case 'created':
                    return Alert::getSucess('Usuário criado com Sucesso!');
                    break;
                case 'duplicated':
                    return Alert::getError('E-mail digitado já utilizado.');
                    break;
            }
        }
    }


?>