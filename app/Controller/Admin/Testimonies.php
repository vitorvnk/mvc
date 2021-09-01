<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;
    use \App\Model\Entity\Testmon as EntityTestimony;
    use \WilliamCosta\DatabaseManager\Pagination;

    class Testimonies extends Page{
        private static function getTestimonyItems($request,&$obPagination){
            //Depoimentos
            $itens='';

            //Quantidade todal de registros
            $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
            
            //Pagina Atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            //Instancia da Paginação
            $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$quantidadeTotal+1);

            //Resultados da página
            $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

            //renderiza o item
            while($obTestimony = $results->fetchObject(EntityTestimony::class)){
                //View do item
                $itens .= View::render('admin/modules/testimonies/item',[
                    'id' => $obTestimony->id,
                    'nome' => $obTestimony->nome,
                    'mensagem' => $obTestimony->mensagem,
                    'data' => date('d/m/Y H:i:s',strtotime($obTestimony->data))
                ]);
            }

            //Retorna o depoimento
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




        //Reponsável por renderizar a view de Listagem Depoimentos
        public static function getTestimonies($request) {
            //Conteudo da Home
            $content = View::render('admin/modules/testimonies/index', [
                'itens' => self::getTestimonyItems($request, $obPagination),
                'pagination' => self::getPagination($request,$obPagination),
                'status' => self::getStatus($request)
            ]);

            //retorna a página completa
            return parent::getPanel('Depoimentos', $content,'testimonies');
        }


        
        //Retorna o formulário para o cadastro de um novo depoimento
        public static function getNewTestimony($request){
            //Conteudo do Formulário
            $content = View::render('admin/modules/testimonies/form', [
                'title' => 'Cadastrar Depoimentos',
                'nome' => '',
                'mensagem' => '',
                'status' => ''
            ]);
        

            //retorna a página completa
            return parent::getPanel('Cadastrar Depoimentos', $content,'testimonies');
        }

        //Responsável por cadastrar um novo depoimento
        public static function setNewTestimony($request){
            //Post Vars
            $postVars = $request->getPostVars();

            //Nova instancia de depoimento
            $obTestimony = new EntityTestimony;
            $obTestimony->nome = $postVars['nome'] ?? '';
            $obTestimony->mensagem = $postVars['mensagem'] ?? '';
            $obTestimony->cadastrar();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=created');
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
                    return Alert::getSucess('Depoimento criado com Sucesso!');
                    break;
                case 'updated':
                    return Alert::getSucess('Depoimento atualizado com Sucesso!');
                    break;
                case 'deleted':
                    return Alert::getSucess('Depoimento excluído com Sucesso!');
                    break;
            }
        }



        //Retorna o formulário para edição de um depimento
        public static function getEditTestimony($request,$id){
            //Obtem o depoimento do Banco de Dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida a instância
            if(!$obTestimony instanceof EntityTestimony){
                $request->getRouter()->redirect('/admin/testimonies');
            }

            //Conteudo do Formulário
            $content = View::render('admin/modules/testimonies/form', [
                'title' => 'Editar Depimento'.'<small> - ID: '.$id.'</small>',
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'status' => self::getStatus($request)
            ]);
        

            //retorna a página completa
            return parent::getPanel('Editar Depoimento', $content,'testimonies');
        }

        //Metodo responsável por gravar as alterações efetuadas
        public static function setEditTestimony($request,$id){
            //Obtem o depoimento do Banco de Dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida a instância
            if(!$obTestimony instanceof EntityTestimony){
                $request->getRouter()->redirect('/admin/testimonies');
            }

            //Post postVars
            $postVars = $request->getPostVars();

            //Atualiza a instância
            $obTestimony->nome = $postVars['nome'] ?? $obTestimony->nome ;
            $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
            $obTestimony->atualizar();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=updated');
        }


        

        //Retorna o formulário para a exclusão de um depoimentos
        public static function getDeleteTestimony($request,$id){
            //Obtem o depoimento do Banco de Dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida a instância
            if(!$obTestimony instanceof EntityTestimony){
                $request->getRouter()->redirect('/admin/testimonies');
            }

            //Conteudo do Formulário
            $content = View::render('admin/modules/testimonies/delete', [
                'title' => 'Excluir Depimento'.'<small> - ID: '.$id.'</small>',
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem
            ]);
        

            //retorna a página completa
            return parent::getPanel('Excluir Depoimento', $content,'testimonies');
        }

        //Metodo responsável por excluir um depoimento
        public static function setDeleteTestimony($request,$id){
            //Obtem o depoimento do Banco de Dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida a instância
            if(!$obTestimony instanceof EntityTestimony){
                $request->getRouter()->redirect('/admin/testimonies');
            }

            //Exclui o Depoimento
            $obTestimony->excluir();

            //Redireciona o usuário
            $request->getRouter()->redirect('/admin/testimonies?status=deleted');
        }




    }


?>