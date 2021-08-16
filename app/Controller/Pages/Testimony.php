<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Testmon as EntityTestimony;
    use \WilliamCosta\DatabaseManager\Pagination;

    class Testimony extends Page{
        //Consulta no Banco de dados e renderizar
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
                $itens .= View::render('pages/testimony/item',[
                    'nome' => $obTestimony->nome,
                    'mensagem' => $obTestimony->mensagem,
                    'data' => date('d/m/Y H:i:s',strtotime($obTestimony->data))
                ]);
            }

            //Retorna o depoimento
            return $itens;
        }


        //retorna o conteudo da tela de Depoimentos
        public static function getTestimonies($request){
            //View da Depoimentos
            $content = View::render('pages/testimonies',[
                'itens' => self::getTestimonyItems($request,$obPagination),
                'pagination' => parent::getPagination($request,$obPagination)
            ]);

            //Retorna a View da página
            return parent::getPage('Depoimentos', $content);
        }

        //Metodo repsonável por cadastrar o depoimento
        public static function insertTestimony($request){
            //Dados do post
            $postVars = $request->getPostVars();

            //Nova instância de Depoimentos
            $obTestimony = new EntityTestimony;
            $obTestimony->nome = $postVars['nome'];
            $obTestimony->mensagem = $postVars['mensagem'];
            $obTestimony->cadastrar();


            //Retorna a página de listagem de depoimentos
            return self::getTestimonies($request);
        }


    }

?>