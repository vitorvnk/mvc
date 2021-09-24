<?php
    namespace App\Controller\Api;

    class Api{
        // Metodo responsável por retornar detalhes da Api
        public static function getDetails($request){
            return [
                'nome' => 'API - Maluca',
                'versao' => 'v1.0',
                'autor' => 'Vitor Alexandre',
                'email' => 'devper.vnk@gmail.com'
            ];
        }

        //Metodo responsável por retornar os detalhes da paginação
        protected static function getPagination($request,$obPagination){
            //QUERY PARAMS  
            $queryParams = $request->getQueryParams();
            $pages = $obPagination->getPages();

            return [
                'paginaAtual' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
                'quantidadePaginas' => !empty($pages) ? count($pages) : 1
            ];
        }

    }


?>