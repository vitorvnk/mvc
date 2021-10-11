<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;
    use \App\Model\Entity\User as EntityUser;
    use \App\WebService\ViaCep;

    class Registro extends Page{
        //Retorna o formulário para o cadastro de um novo Usuário
        public static function getNewUser($request){
            //Conteudo do Formulário
            $content = View::render('admin/registro', [
                'title' => 'Cadastrar Usuários',
                'status' => self::getStatus($request)
            ]);

            //Retorna a Página completa
            return parent::getPage('Registro', $content);
        }
            /*
            $dadosCEP = ViaCep::consultarCEP(17511470);
            echo "<pre>";
            print_r($dadosCEP);
            echo "<pre>";
            */
        

         //Responsável por cadastrar um novo Usuário
        public static function setNewUser($request){
            //Post Vars
            $postVars = $request->getPostVars();
            $nome = $postVars['nome'] ?? '';
            $email = $postVars['email'] ?? '';
            $senha = $postVars['senha'] ?? '';
            $senhaConfirm = $postVars['senhaConfirm'] ?? '';
            $cep = $postVars['cep'] ?? '';
            $cidade = $postVars['cidade'] ?? '';
            $uf = $postVars['uf'] ?? '';
            $bairro = $postVars['bairro'] ?? '';
            $logradouro = $postVars['logradouro'] ?? '';
            $numero = $postVars['numero'] ?? '';

            //Valida o e-mail do usuário
            $obUser = EntityUser::getUserByEmail($email);

            if($obUser instanceof EntityUser){
                //Redireciona o usuário
                $request->getRouter()->redirect('/admin/registro?status=duplicated');
            }
            if($senha != $senhaConfirm){
                //Redireciona o usuário
                $request->getRouter()->redirect('/admin/registro?status=passwordincorrect');
            }

            //Nova instancia de Usuário
            $obUser = new EntityUser;
            $obUser->nome = $nome;
            $obUser->email = $email;
            $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
            $obUser->cep = $cep;
            $obUser->cidade = $cidade;
            $obUser->uf = $uf;
            $obUser->bairro = $bairro;
            $obUser->logradouro = $logradouro;
            $obUser->numero = $numero;
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
                case 'passwordincorrect':
                        return Alert::getError('Senhas não coincidem.');
                        break;
            }
        }
    }
?>