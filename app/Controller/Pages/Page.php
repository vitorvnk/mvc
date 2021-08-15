<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;

    class Page{
        //Retorna o topo da página
        private static function getHeader() {
            return View::render('pages/header');
        }
        //Retorna o rodapé da página
        private static function getFooter() {
            return View::render('pages/footer');
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
                $links .= View::render('pages/pagination/link',[
                    'page' =>$page['page'],
                    'link' => $link,
                    'active' => $page['current'] ? 'active' : ''
                ]);

                //Renderiza a BOX de Paginação
                return View::render('pages/pagination/box',[
                    'links' => $links
                ]);
            }
        }

        //retorna o conteudo da Pagina genética
        public static function getPage($title,$content){
            return View::render('pages/page',[
                'title' =>$title,
                'header' => self::getHeader(),
                'content' =>$content,
                'footer' => self::getFooter()
            ]);
        }

    }

?>