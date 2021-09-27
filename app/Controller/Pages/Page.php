<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;

    class Page{
        private static $modules = [
            'Home' => [
                'label' =>'Home',
                'link' => URL.'/'
            ],
            'Galeria' => [
                'label' =>'Galeria',
                'link' => URL.'/galeria'
            ],
            'Depoimentos' => [
                'label' =>'Depoimentos',
                'link' => URL.'/depoimentos'
            ],
            'Sobre' => [
                'label' =>'Sobre',
                'link' => URL.'/sobre'
            ]
        ];

        //Retorna o topo da página
        private static function getHeader($currentModule) {
            //Links do menu
            $links = '';

            //Itera os módulos
            foreach(self::$modules as $hash => $module){
                $links .= View::render('pages/menu/link',[
                    'label' => $module['label'],
                    'link' => $module['link'],
                    'current' => $hash == $currentModule ? 'text-success' : ''
                ]);
            }

            //retorna a renderização do menu
            return View::render('pages/menu/box', [
                'links' => $links
            ]);
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
                'header' => self::getHeader($title),
                'content' =>$content,
                'footer' => self::getFooter()
            ]);
        }

    }