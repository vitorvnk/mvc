<?php
    namespace App\Controller\Api;
    use \App\Model\Entity\Testmon as EntityTestimony;
    use \WilliamCosta\DatabaseManager\Pagination;

    class Testimony extends Api{
        private static function getTestimonyItems($request,&$obPagination){
            //Depoimentos
            $itens= [];

            //Quantidade todal de registros
            $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
            
            //Pagina Atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            //Instancia da Paginação
            $obPagination = new Pagination($quantidadeTotal,$paginaAtual,5);

            //Resultados da página
            $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

            //renderiza o item
            while($obTestimony = $results->fetchObject(EntityTestimony::class)){
                //View do item
                $itens[]= [
                    'id' => (int)$obTestimony->id,
                    'nome' => $obTestimony->nome,
                    'mensagem' => $obTestimony->mensagem,
                    'data' => $obTestimony->data
                ];
            }
            //Retorna o depoimento
            return $itens;
        }




        // Metodo responsável por retornar os depoimentos cadastrados
        public static function getTestimonies($request){
            return [
                'depoimentos' => self::getTestimonyItems($request, $obPagination),
                'paginacao' => self::getPagination($request,$obPagination) 
            ];
        }

        // metodo responsável por retornar os detalhes de apenas um depoimento
        public static function getTestimony($request,$id){
            //Valida o ID do depoimento
            if(!is_numeric($id)){
                throw new \Exception("Erro! O ID '".$id."' não é válido.", 400);
            }


            //Busca depoimentos no banco de dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida se o depoimento existe
            if (!$obTestimony instanceof EntityTestimony){
                throw new \Exception("Erro! O depoimento '".$id."' não foi encontrado no banco.", 404);
            }

            //Retorna os detalhes do depoimento
            return [
                'id' => (int)$obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => $obTestimony->data
            ];
        }



    }


?>