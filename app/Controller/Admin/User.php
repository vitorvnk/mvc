<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;
    use \App\Model\Entity\User as EntityUser;
    use \WilliamCosta\DatabaseManager\Pagination;

    class User extends Page{
        private static function getUsersItems($request,&$obPagination){
            //usuários
            $itens='';

            //Quantidade todal de registros
            $quantidadeTotal = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

            //Pagina Atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            //Instancia da Paginação
            $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$quantidadeTotal+1);

            //Resultados da página
            $results = EntityUser::getUsers(null,'id DESC',$obPagination->getLimit());

            //renderiza o item
            while($obUser = $results->fetchObject(EntityUser::class)){
                //View do item
                $itens .= View::render('admin/modules/users/item',[
                    'id' => $obUser->id,
                    'nome' => $obUser->nome,
                    'email' => $obUser->email
                ]);
            }

            //Retorna o usuário
            return $itens;
        }

        public static function getPagination($request,$obPagination){
            //Obter as páginas
            $pages = $obPagination->getPages();

            //Verifica a quantidade de paginas
            if(count($pages) <= 1) return '';

            //Links
            $links = '';

            //URL atual (Sem GETs)
            $url = $request->getRouter()->getCurrentUrl();

            //GETs
            $queryParams = $request->getQueryParams();

            //Renderiza os Links
            foreach($pages as $page) {
                //Altera a página
                $queryParams['page'] = $page['page'];

                //Links
                $link = $url.'?'.http_build_query($queryParams);

                //View
                $links .= View::render('admin/pagination/link',[
                    'page' =>$page['page'],
                    'link' => $link,
                    'active' => $page['current'] ? 'active' : ''
                ]);

                //Renderiza a BOX de Paginação
                return View::render('admin/pagination/box',[
                    'links' => $links
                ]);
            }
        }




        //Reponsável por renderizar a view de Listagem usuários
        public static function getUsers($request) {
            //Conteudo da Home
            $content = View::render('admin/modules/users/index', [
                'itens' => self::getUsersItems($request, $obPagination),
                'pagination' => self::getPagination($request,$obPagination),
                'status' => self::getStatus($request)
            ]);

            //retorna a página completa
            return parent::getPanel('Usuários', $content,'users');
        }


        
        //Retorna o formulário para o cadastro de um novo Usuário
        public static function getNewUser($request){
            //Conteudo do Formulário
            $content = View::render('admin/modules/users/form', [
                'title' => 'Cadastrar Usuários',
                'nome' => '',
                'email' => '',
                'status' => self::getStatus($request)
            ]);
        

            //retorna a página completa
            return parent::getPanel('Cadastrar Usuários', $content,'users');
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
                $request->getRouter()->redirect('/admin/users/new?status=duplicated');
            }

            //Nova instancia de Usuário
            $obUser = new EntityUser;
            $obUser->nome = $nome;
            $obUser->email = $email;
            $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
            $obUser->cadastrar();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=created');
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
                case 'updated':
                    return Alert::getSucess('Usuário atualizado com Sucesso!');
                    break;
                case 'deleted':
                    return Alert::getSucess('Usuário excluído com Sucesso!');
                    break;
                case 'duplicated':
                    return Alert::getError('E-mail digitado já utilizado.');
                    break;
            }
        }



        //Retorna o formulário para edição de um usuário
        public static function getEditUser($request,$id){
            //Obtem o usuário do Banco de Dados
            $obUser = EntityUser::getUserById($id);

            //Valida a instância
            if(!$obUser instanceof EntityUser){
                $request->getRouter()->redirect('/admin/users');
            }

            //Conteudo do Formulário
            $content = View::render('admin/modules/users/form', [
                'title' => 'Editar Usuário'.'<small> - ID: '.$id.'</small>',
                'nome' => $obUser->nome,
                'email' => $obUser->email,
                'status' => self::getStatus($request)
            ]);
        

            //retorna a página completa
            return parent::getPanel('Editar Usuário', $content,'users');
        }

        //Metodo responsável por gravar as alterações efetuadas
        public static function setEditUser($request,$id){
            //Obtem o usuário do Banco de Dados
            $obUser = EntityUser::getUserById($id);

            //Valida a instância
            if(!$obUser instanceof EntityUser){
                $request->getRouter()->redirect('/admin/users');
            }

            //Post postVars
            $postVars = $request->getPostVars();
            $nome = $postVars['nome'] ?? '';
            $email = $postVars['email'] ?? '';
            $senha = $postVars['senha'] ?? '';

            //Valida o e-mail do usuário
            $obUserEmail = EntityUser::getUserByEmail($email);
            if($obUserEmail instanceof EntityUser && $obUserEmail->id != $id){
                //Redireciona o usuário
                $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
            }

            //Atualiza a instância
            $obUser->nome = $nome ;
            $obUser->email = $email ;
            $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
            $obUser->atualizar();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=updated');
        }


        

        //Retorna o formulário para a exclusão de um Usuário
        public static function getDeleteUser($request,$id){
            //Obtem o Usuário do Banco de Dados
            $obUser = EntityUser::getUserById($id);

            //Valida a instância
            if(!$obUser instanceof EntityUser){
                $request->getRouter()->redirect('/admin/users');
            }

            //Conteudo do Formulário
            $content = View::render('admin/modules/users/delete', [
                'title' => 'Excluir Depimento'.'<small> - ID: '.$id.'</small>',
                'nome' => $obUser->nome,
                'email' => $obUser->email
            ]);
        

            //retorna a página completa
            return parent::getPanel('Excluir usuário', $content,'users');
        }

        //Metodo responsável por excluir um usuário
        public static function setDeleteUser($request,$id){
            //Obtem o Usuário do Banco de Dados
            $obUser = EntityUser::getUserById($id);

            //Valida a instância
            if(!$obUser instanceof EntityUser){
                $request->getRouter()->redirect('/admin/users');
            }

            //Exclui o usuário
            $obUser->excluir();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/users?status=deleted');
        }




    }


?>