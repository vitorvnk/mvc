<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Page{
        //Modulos disponíveis no painel
        private static $modules = [
            'home' => [
                'label' =>'Home',
                'link' => URL.'/admin'
            ],
            'testimonies' => [
                'label' =>'Depoimentos',
                'link' => URL.'/admin/testimonies'
            ],
            'users' => [
                'label' =>'Usuários',
                'link' => URL.'/admin/users'
            ]
        ];

        //Retorna o conteudo (View) da estrutura genética de página do painel de controle
        public static function getPage($title, $content) {
            return View::render('admin/page',[
                'title' => $title,
                'content' => $content,
                'footer' => self::getFooter()
            ]);
        }

        //renderiza a view do painel
        private static function getMenu($currentModule){
            //Links do menu
            $links = '';

            //Itera os módulos
            foreach(self::$modules as $hash => $module){
                $links .= View::render('admin/menu/link',[
                    'label' => $module['label'],
                    'link' => $module['link'],
                    'current' => $hash == $currentModule ? 'text-success' : ''
                ]);
            }

            //retorna a renderização do menu
            return View::render('admin/menu/box', [
                'links' => $links
            ]);
        }

        //Metodo responsável por renderizar a view do painel com conteudos dinamicos
        public static function getPanel($title, $content, $currentModule) {
             //renderiza a view do painel
            $contentPanel = View::render('admin/panel',[
                'menu' => self::getMenu($currentModule),
                'content' =>$content,
                'footer' => self::getFooter()
            ]);

            //retorna a página renderizada
            return self::getPage($title, $contentPanel);
        }
        //Retorna o rodapé da página
        private static function getFooter() {
            return View::render('pages/footer');
        }

    }

?>