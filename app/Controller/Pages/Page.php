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